<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rencontre;
use App\Models\Equipe;
use App\Models\Pool;
use App\Models\Saison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Exports\RencontresExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\StatistiquesHelper;

class RencontreController extends Controller
{
    public function index(Request $request)
    {
        // Déterminer la saison active (champ 'active')
        $saison = \App\Models\Saison::where('active', 1)->first();
        if ($request->filled('saison_id')) {
            $saison = Saison::find($request->saison_id);
        }
        // Charger les pools et équipes de la saison sélectionnée (ou vide si aucune)
        $pools = $saison ? Pool::where('saison_id', $saison->id)->get() : collect();
        $equipes = $saison ? Equipe::where('saison_id', $saison->id)->get() : collect();
        $saisons = Saison::orderByDesc('date_debut')->get();

        // Construire la requête filtrée
        $query = Rencontre::with(['equipe1', 'equipe2', 'pool']);
        if ($request->filled('pool_id')) {
            $query->where('pool_id', $request->pool_id);
        }
        if ($request->filled('equipe_id')) {
            $query->where(function($q) use ($request) {
                $q->where('equipe1_id', $request->equipe_id)
                  ->orWhere('equipe2_id', $request->equipe_id);
            });
        }
        if ($request->filled('journee')) {
            $query->where('journee', $request->journee);
        }
        if ($saison) {
            $query->where('saison_id', $saison->id);
        }
        if ($request->filled('type_rencontre')) {
            $query->where('type_rencontre', $request->type_rencontre);
        }
        // Filtre par match joué/non joué
        if ($request->filled('etat_match')) {
            if ($request->etat_match === 'joue') {
                $query->whereNotNull('score_equipe1')->whereNotNull('score_equipe2');
            } elseif ($request->etat_match === 'non_joue') {
                $query->whereNull('score_equipe1')->orWhereNull('score_equipe2');
            }
        }
        // Pagination (20 par page)
        $rencontres = $query->orderBy('journee')->orderBy('date')->paginate(20)->withQueryString();

        return view('admin.rencontres.index', compact('rencontres', 'saison', 'pools', 'equipes', 'saisons'));
    }

    public function create()
    {
        $saison = Saison::where('active', 1)->orderByDesc('date_debut')->first();
        $pools = $saison ? Pool::where('saison_id', $saison->id)->get() : collect();
        $equipes = $saison ? Equipe::where('saison_id', $saison->id)->get() : collect();
        $journees = collect();
        if ($pools->count() > 0) {
            $poolIds = $pools->pluck('id');
            $journees = Rencontre::whereIn('pool_id', $poolIds)
                ->whereNotNull('journee')
                ->orderBy('journee')
                ->pluck('journee')
                ->unique()
                ->values();
        }
        return view('admin.rencontres.create', compact('pools', 'equipes', 'saison', 'journees'));
    }

    public function store(Request $request)
    {
        $saison = Saison::where('active', 1)->orderByDesc('date_debut')->first();
        // Validation personnalisée selon le contexte
        $rules = [
            'date' => 'required|date',
            'heure' => 'required',
            'stade' => 'required|string|max:255',
            'journee' => 'nullable|integer',
            'logo_equipe1_libre' => 'nullable|image|max:2048',
            'logo_equipe2_libre' => 'nullable|image|max:2048',
        ];
        $messages = [
            'date.required' => 'La date du match est obligatoire.',
            'heure.required' => "L'heure du match est obligatoire.",
            'stade.required' => 'Le stade est obligatoire.',
            'equipe1_id.required' => 'Veuillez sélectionner ou saisir une équipe 1.',
            'equipe2_id.required' => 'Veuillez sélectionner ou saisir une équipe 2.',
            'equipe1_id.different' => 'Les deux équipes doivent être différentes.',
            'equipe2_id.different' => 'Les deux équipes doivent être différentes.',
            'logo_equipe1_libre.image' => 'Le logo de l\'équipe 1 doit être une image.',
            'logo_equipe2_libre.image' => 'Le logo de l\'équipe 2 doit être une image.',
            'logo_equipe1_libre.max' => 'Le logo de l\'équipe 1 ne doit pas dépasser 2 Mo.',
            'logo_equipe2_libre.max' => 'Le logo de l\'équipe 2 ne doit pas dépasser 2 Mo.',
        ];
        if (!$request->has('hors_calendrier')) {
            $rules['pool_id'] = 'required|exists:pools,id';
            $rules['journee'] = 'required|integer';
        }
        if ($request->has('hors_calendrier')) {
            // Forcer le type à 'amical' si hors calendrier
            $request->merge(['type_rencontre' => 'amical']);
        }
        $request->validate($rules, $messages);
        $data = $request->only(['pool_id', 'equipe1_id', 'equipe2_id', 'date', 'heure', 'stade', 'journee', 'type_rencontre']);
        $data['saison_id'] = $saison?->id;
        if ($request->has('hors_calendrier')) {
            $data['type_rencontre'] = 'amical';
            $data['pool_id'] = null;
            $data['journee'] = null;
        }
        // Gestion équipe 1
        if ($request->equipe1_mode === 'libre') {
            $data['equipe1_libre'] = $request->equipe1_libre;
            $data['equipe1_id'] = null;
        } else {
            $data['equipe1_id'] = $request->equipe1_id;
            $data['equipe1_libre'] = null;
        }
        // Gestion équipe 2
        if ($request->equipe2_mode === 'libre') {
            $data['equipe2_libre'] = $request->equipe2_libre;
            $data['equipe2_id'] = null;
        } else {
            $data['equipe2_id'] = $request->equipe2_id;
            $data['equipe2_libre'] = null;
        }
        // Gestion pool/journee si renseignés
        if ($request->filled('pool_id')) $data['pool_id'] = $request->pool_id;
        if ($request->filled('journee')) $data['journee'] = $request->journee;
        // Gestion upload logos équipes libres
        if ($request->hasFile('logo_equipe1_libre')) {
            $data['logo_equipe1_libre'] = $request->file('logo_equipe1_libre')->store('logos_equipes_libres', 'public');
        }
        if ($request->hasFile('logo_equipe2_libre')) {
            $data['logo_equipe2_libre'] = $request->file('logo_equipe2_libre')->store('logos_equipes_libres', 'public');
        }
        // Gestion équipe du MVP libre
        $data['mvp_libre_equipe'] = $request->input('mvp_libre_equipe');
        $data['updated_by'] = auth()->user() ? auth()->user()->id : null;
        Rencontre::create($data);
        // Recalcul des stats si scores renseignés à la création
        if (!empty($data['score_equipe1']) && !empty($data['score_equipe2']) && !empty($data['equipe1_id']) && !empty($data['equipe2_id']) && !empty($data['saison_id'])) {
            StatistiquesHelper::updateStatsForTeam($data['equipe1_id'], $data['saison_id']);
            StatistiquesHelper::updateStatsForTeam($data['equipe2_id'], $data['saison_id']);
        }
        Log::info('Création d\'une rencontre', ['date' => $data['date'], 'admin_id' => Auth::id()]);
        return redirect()->route('admin.rencontres.index')->with('success', 'Rencontre ajoutée avec succès.');
    }

    public function edit($id)
    {
        $rencontre = Rencontre::findOrFail($id);
        $saison = $rencontre->saison_id ? Saison::find($rencontre->saison_id) : Saison::where('active', 1)->orderByDesc('date_debut')->first();
        $pools = $saison ? Pool::where('saison_id', $saison->id)->get() : collect();
        $equipes = $saison ? Equipe::where('saison_id', $saison->id)->get() : collect();
        return view('admin.rencontres.edit', compact('rencontre', 'pools', 'equipes', 'saison'));
    }

    /**
     * Recalcule et met à jour les statistiques pour les deux équipes d'un match
     */
    protected function updateStatsForTeams($equipe1_id, $equipe2_id, $saison_id)
    {
        foreach ([$equipe1_id, $equipe2_id] as $equipe_id) {
            $equipe = \App\Models\Equipe::find($equipe_id);
            if (!$equipe) continue;
            $rencontres = \App\Models\Rencontre::where(function($q) use ($equipe_id) {
                $q->where('equipe1_id', $equipe_id)->orWhere('equipe2_id', $equipe_id);
            })
            ->where('saison_id', $saison_id)
            ->whereNotNull('score_equipe1')
            ->whereNotNull('score_equipe2')
            ->get();
            $points = $victoires = $nuls = $defaites = $buts_pour = $buts_contre = $cartons_jaunes = $cartons_rouges = 0;
            foreach ($rencontres as $match) {
                $isEquipe1 = $match->equipe1_id == $equipe_id;
                $scoreFor = $isEquipe1 ? $match->score_equipe1 : $match->score_equipe2;
                $scoreAgainst = $isEquipe1 ? $match->score_equipe2 : $match->score_equipe1;
                $buts_pour += $scoreFor;
                $buts_contre += $scoreAgainst;
                if ($scoreFor > $scoreAgainst) $victoires++;
                elseif ($scoreFor == $scoreAgainst) $nuls++;
                else $defaites++;
                // Cartons (optionnel, à adapter si tu as des relations)
                if ($match->relationLoaded('cartons')) {
                    $cartons_jaunes += $match->cartons->where('joueur.equipe_id', $equipe_id)->where('type', 'jaune')->count();
                    $cartons_rouges += $match->cartons->where('joueur.equipe_id', $equipe_id)->where('type', 'rouge')->count();
                }
            }
            $points = $victoires * 3 + $nuls;
            \App\Models\StatistiqueEquipe::updateOrCreate(
                ['equipe_id' => $equipe_id, 'saison_id' => $saison_id],
                [
                    'points' => $points,
                    'victoires' => $victoires,
                    'nuls' => $nuls,
                    'defaites' => $defaites,
                    'buts_pour' => $buts_pour,
                    'buts_contre' => $buts_contre,
                    'cartons_jaunes' => $cartons_jaunes,
                    'cartons_rouges' => $cartons_rouges,
                ]
            );
        }
    }

    public function update(Request $request, $id)
    {
        $rencontre = Rencontre::findOrFail($id);
        $rules = [
            'pool_id' => 'required|exists:pools,id',
            'equipe1_id' => 'required|exists:equipes,id|different:equipe2_id',
            'equipe2_id' => 'required|exists:equipes,id|different:equipe1_id',
            'date' => 'required|date',
            'heure' => 'required',
            'stade' => 'required|string|max:255',
            'journee' => 'nullable|integer',
            'score_equipe1' => 'nullable|integer',
            'score_equipe2' => 'nullable|integer',
            'logo_equipe1_libre' => 'nullable|image|max:2048',
            'logo_equipe2_libre' => 'nullable|image|max:2048',
        ];
        $messages = [
            'logo_equipe1_libre.image' => 'Le logo de l\'équipe 1 doit être une image.',
            'logo_equipe2_libre.image' => 'Le logo de l\'équipe 2 doit être une image.',
            'logo_equipe1_libre.max' => 'Le logo de l\'équipe 1 ne doit pas dépasser 2 Mo.',
            'logo_equipe2_libre.max' => 'Le logo de l\'équipe 2 ne doit pas dépasser 2 Mo.',
        ];
        $request->validate($rules, $messages);
        $data = $request->only(['pool_id', 'equipe1_id', 'equipe2_id', 'date', 'heure', 'stade', 'journee', 'type_rencontre', 'score_equipe1', 'score_equipe2']);
        $data['updated_by'] = auth()->user() ? auth()->user()->id : null;
        $rencontre->update($data);
        // Recalcul des stats après modification du score
        if ($rencontre->score_equipe1 !== null && $rencontre->score_equipe2 !== null) {
            StatistiquesHelper::updateStatsForTeam($rencontre->equipe1_id, $rencontre->saison_id);
            StatistiquesHelper::updateStatsForTeam($rencontre->equipe2_id, $rencontre->saison_id);
        }
        Log::info('Modification d\'une rencontre', ['rencontre_id' => $rencontre->id, 'admin_id' => Auth::id()]);
        // Validation supplémentaire : deux équipes doivent être dans le même pool sauf si rencontre hors calendrier (pool_id ou journee null)
        if ($request->filled('pool_id') && $request->filled('equipe1_id') && $request->filled('equipe2_id') && $request->filled('journee')) {
            $equipe1 = \App\Models\Equipe::find($request->equipe1_id);
            $equipe2 = \App\Models\Equipe::find($request->equipe2_id);
            if ($equipe1 && $equipe2 && $equipe1->pool_id != $equipe2->pool_id) {
                return back()->withInput()->withErrors(['equipe2_id' => 'Les deux équipes doivent appartenir au même pool pour une rencontre de championnat.']);
            }
        }
        return redirect()->route('admin.rencontres.index')->with('success', 'Rencontre mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $rencontre = Rencontre::findOrFail($id);
        $rencontre->delete();
        Log::info('Suppression d\'une rencontre', ['rencontre_id' => $rencontre->id, 'admin_id' => Auth::id()]);
        return redirect()->route('admin.rencontres.index')->with('success', 'Rencontre supprimée avec succès.');
    }

    public function organiserJournees(Request $request)
    {
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        $pools = collect();
        $saison_id = $request->saison_id;
        if (!$saison_id) {
            $saison = \App\Models\Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
            $saison_id = $saison?->id;
        }
        $journeesByPool = [];
        if ($saison_id) {
            $pools = \App\Models\Pool::withCount('equipes')->where('saison_id', $saison_id)->get();
            foreach ($pools as $pool) {
                $journees = \App\Models\Rencontre::where('pool_id', $pool->id)
                    ->whereNotNull('journee')
                    ->orderBy('journee')
                    ->pluck('journee')
                    ->unique()
                    ->values();
                $journeesByPool[$pool->id] = $journees;
            }
        }
        return view('admin.rencontres.organiser_journees', compact('saisons', 'pools', 'saison_id', 'journeesByPool'));
    }

    public function genererJournees(Request $request)
    {
        $pool_id = $request->pool_id;
        $forcer = $request->input('forcer', false);
        $pool = \App\Models\Pool::with('equipes')->find($pool_id);
        if (!$pool) {
            return redirect()->route('admin.rencontres.genererForm')->with('error', "Le pool sélectionné est introuvable. Veuillez choisir un pool valide.");
        }
        $equipes = $pool->equipes;
        $nb = $equipes->count();
        if ($nb < 2) {
            return redirect()->route('admin.rencontres.genererForm')->with('error', "Le pool '$pool->nom' ne contient pas assez d'équipes pour générer un calendrier.");
        }
        if (!($nb % 2 == 0 || $nb == 14)) {
            return redirect()->route('admin.rencontres.genererForm')->with('error', "Le nombre d'équipes dans le pool '$pool->nom' doit être pair ou égal à 14 pour générer un calendrier.");
        }
        // Vérifier si des rencontres du pool ont déjà des résultats
        $rencontres = \App\Models\Rencontre::where('pool_id', $pool->id)->get();
        $hasResults = false;
        foreach ($rencontres as $r) {
            if ($r->score_equipe1 !== null || $r->score_equipe2 !== null || $r->buts()->count() > 0 || $r->cartons()->count() > 0) {
                $hasResults = true;
                break;
            }
        }
        if ($hasResults && !$forcer) {
            return redirect()->route('admin.rencontres.genererForm')->with('error_force', [
                'message' => "Le pool '$pool->nom' contient déjà des matchs joués. Voulez-vous supprimer tous les résultats et régénérer le calendrier ?",
                'pool_id' => $pool->id
            ]);
        }
        if ($hasResults && $forcer) {
            foreach ($rencontres as $r) {
                $r->buts()->delete();
                $r->cartons()->delete();
                $r->score_equipe1 = null;
                $r->score_equipe2 = null;
                $r->save();
            }
        }
        // Supprimer les confrontations existantes du pool
        \App\Models\Rencontre::where('pool_id', $pool->id)->delete();
        // Générer le calendrier round-robin aller-retour
        $ids = $equipes->pluck('id')->toArray();
        $journees = [];
        $n = count($ids);
        $rounds = ($n - 1) * 2; // Aller-retour
        $teams = $ids;
        $nbRencontresAvant = \App\Models\Rencontre::where('pool_id', $pool->id)->count();
        for ($phase = 0; $phase < 2; $phase++) { // Aller puis retour
            $t = $teams;
            for ($j = 0; $j < $n - 1; $j++) {
                $matches = [];
                for ($i = 0; $i < $n / 2; $i++) {
                    $e1 = $t[$i];
                    $e2 = $t[$n - 1 - $i];
                    if ($phase == 0) {
                        $matches[] = [$e1, $e2];
                    } else {
                        $matches[] = [$e2, $e1];
                    }
                }
                $journees[] = $matches;
                // Rotation
                $t = array_merge([$t[0]], [end($t)], array_slice($t, 1, -1));
            }
        }
        // Enregistrement en base
        $stades = ['COKM', 'Annexe 1', 'Annexe 2', 'Jolie site', 'SGK'];
        $heureDebut = 12;
        $heureFin = 18;
        $saisonDebut = $pool->saison->date_debut ?? now();
        $nbRencontresCreees = 0;
        $equipesNoms = $equipes->pluck('nom')->toArray();
        foreach ($journees as $num => $matches) {
            $dateJournee = \Carbon\Carbon::parse($saisonDebut)->addDays($num * 3);
            $nbMatchsJournee = count($matches);
            $plageHoraire = $heureFin - $heureDebut;
            foreach ($matches as $k => $match) {
                $heureMatch = $heureDebut + ($nbMatchsJournee > 1 ? intval($plageHoraire * $k / max(1, $nbMatchsJournee - 1)) : 0);
                $heureStr = str_pad($heureMatch, 2, '0', STR_PAD_LEFT) . ':00';
                $stade = $stades[($k + $num) % count($stades)];
                $created = \App\Models\Rencontre::create([
                    'pool_id' => $pool->id,
                    'equipe1_id' => $match[0],
                    'equipe2_id' => $match[1],
                    'saison_id' => $pool->saison_id,
                    'journee' => $num + 1,
                    'date' => $dateJournee->format('Y-m-d'),
                    'heure' => $heureStr,
                    'stade' => $stade
                ]);
                if ($created) $nbRencontresCreees++;
            }
        }
        $nbRencontresApres = \App\Models\Rencontre::where('pool_id', $pool->id)->count();
        if ($nbRencontresApres === 0) {
            return redirect()->route('admin.rencontres.genererForm')->with('error', "Aucune rencontre n'a pu être générée pour le pool '$pool->nom'. Vérifiez que les équipes sont bien configurées et qu'il n'y a pas de problème de données.");
        }
        // Message enrichi
        $resume = [
            'pool' => $pool->nom,
            'nb_matchs' => $nbRencontresCreees,
            'equipes' => $equipesNoms
        ];
        return redirect()->route('admin.rencontres.genererForm')->with('success', "Le calendrier a été généré avec succès pour le pool '$pool->nom'.")->with('resume', $resume);
    }

    public function planifier()
    {
        $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        $pools = $saison ? Pool::where('saison_id', $saison->id)->get() : collect();
        $equipes = $saison ? Equipe::where('saison_id', $saison->id)->get() : collect();
        return view('admin.rencontres.planifier', compact('pools', 'equipes', 'saison'));
    }

    public function resultats(Request $request)
    {
        $saisons = Saison::orderByDesc('date_debut')->get();
        $saison_id = $request->saison_id;
        if (!$saison_id) {
            $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
            $saison_id = $saison?->id;
        }
        $pools = $saison_id ? Pool::where('saison_id', $saison_id)->get() : collect();
        $pool_id = $request->pool_id;
        $journees = collect();
        $rencontres = collect();
        $equipe_id = $request->equipe_id;
        if ($pool_id) {
            $journees = Rencontre::where('pool_id', $pool_id)
                ->whereNotNull('journee')
                ->orderBy('journee')
                ->pluck('journee')
                ->unique()
                ->values();
        }
        $query = Rencontre::with(['equipe1', 'equipe2'])
            ->whereNotNull('score_equipe1')
            ->whereNotNull('score_equipe2');
        if ($saison_id) {
            $query->where('saison_id', $saison_id);
        }
        if ($pool_id) {
            $query->where('pool_id', $pool_id);
        }
        if ($request->filled('journee')) {
            $query->where('journee', $request->journee);
        }
        if ($equipe_id) {
            $query->where(function($q) use ($equipe_id) {
                $q->where('equipe1_id', $equipe_id)->orWhere('equipe2_id', $equipe_id);
            });
        }
        $rencontres = $query->orderBy('journee')->orderBy('date')->get()->groupBy('journee');
        return view('admin.rencontres.resultats', compact('rencontres', 'saisons', 'saison_id', 'pools', 'pool_id', 'journees', 'equipe_id'));
    }

    public function editResultat($id)
    {
        $rencontre = Rencontre::findOrFail($id);
        // Gestion équipe libre ou non (toujours charger les joueurs pour l'équipe du championnat)
        $joueursEquipe1 = collect();
        $joueursEquipe2 = collect();
        if ($rencontre->equipe1 && !$rencontre->equipe1_libre) {
            $joueursEquipe1 = $rencontre->equipe1->joueurs ?? collect();
        }
        if ($rencontre->equipe2 && !$rencontre->equipe2_libre) {
            $joueursEquipe2 = $rencontre->equipe2->joueurs ?? collect();
        }
        return view('admin.rencontres.edit_resultat', compact('rencontre', 'joueursEquipe1', 'joueursEquipe2'));
    }

    public function updateResultat(Request $request, $id)
    {
        $rencontre = Rencontre::findOrFail($id);
        $request->validate([
            'score_equipe1' => 'required|integer|min:0',
            'score_equipe2' => 'required|integer|min:0',
            'minutes_buteurs_equipe1' => 'array',
            'minutes_buteurs_equipe1.*' => 'required|integer|min:0',
            'minutes_buteurs_equipe2' => 'array',
            'minutes_buteurs_equipe2.*' => 'required|integer|min:0',
            'minutes_cartons_equipe1' => 'array',
            'minutes_cartons_equipe1.*' => 'required|integer|min:0',
            'minutes_cartons_equipe2' => 'array',
            'minutes_cartons_equipe2.*' => 'required|integer|min:0',
        ], [
            'score_equipe1.required' => 'Le score de l\'équipe 1 est obligatoire.',
            'score_equipe2.required' => 'Le score de l\'équipe 2 est obligatoire.',
            'score_equipe1.integer' => 'Le score de l\'équipe 1 doit être un nombre entier.',
            'score_equipe2.integer' => 'Le score de l\'équipe 2 doit être un nombre entier.',
            'score_equipe1.min' => 'Le score de l\'équipe 1 doit être positif ou nul.',
            'score_equipe2.min' => 'Le score de l\'équipe 2 doit être positif ou nul.',
            'minutes_buteurs_equipe1.*.required' => 'La minute de chaque buteur de l\'équipe 1 est obligatoire.',
            'minutes_buteurs_equipe2.*' => 'La minute de chaque buteur de l\'équipe 2 est obligatoire.',
            'minutes_cartons_equipe1.*.required' => 'La minute de chaque carton de l\'équipe 1 est obligatoire.',
            'minutes_cartons_equipe2.*' => 'La minute de chaque carton de l\'équipe 2 est obligatoire.',
            'minutes_buteurs_equipe1.*.integer' => 'La minute de chaque buteur de l\'équipe 1 doit être un nombre entier.',
            'minutes_buteurs_equipe2.*.integer' => 'La minute de chaque buteur de l\'équipe 2 doit être un nombre entier.',
            'minutes_cartons_equipe1.*.integer' => 'La minute de chaque carton de l\'équipe 1 doit être un nombre entier.',
            'minutes_cartons_equipe2.*' => 'La minute de chaque carton de l\'équipe 2 doit être un nombre entier.',
            'minutes_buteurs_equipe1.*.min' => 'La minute de chaque buteur de l\'équipe 1 doit être positive ou nulle.',
            'minutes_buteurs_equipe2.*.min' => 'La minute de chaque buteur de l\'équipe 2 doit être positive ou nulle.',
            'minutes_cartons_equipe1.*.min' => 'La minute de chaque carton de l\'équipe 1 doit être positive ou nulle.',
            'minutes_cartons_equipe2.*' => 'La minute de chaque carton de l\'équipe 2 doit être positive ou nulle.',
        ]);

        // Mise à jour des scores
        $rencontre->score_equipe1 = $request->score_equipe1;
        $rencontre->score_equipe2 = $request->score_equipe2;
        $rencontre->save();

        // Suppression des anciens buteurs et cartons
        $rencontre->buts()->delete();
        $rencontre->cartons()->delete();

        // Ajout buteurs équipe 1 (championnat)
        if ($request->has('buteurs_equipe1')) {
            foreach ($request->buteurs_equipe1 as $index => $joueur_id) {
                $minute = $request->minutes_buteurs_equipe1[$index] ?? null;
                if ($joueur_id && $minute !== null) {
                    $rencontre->buts()->create([
                        'joueur_id' => $joueur_id,
                        'equipe_id' => $rencontre->equipe1_id,
                        'minute' => $minute
                    ]);
                }
            }
        }
        // Ajout buteurs équipe 1 (libre)
        if ($request->has('buteurs_equipe1_libre')) {
            foreach ($request->buteurs_equipe1_libre as $index => $nom) {
                $minute = $request->minutes_buteurs_equipe1_libre[$index] ?? null;
                if ($nom && $minute !== null) {
                    $rencontre->buts()->create([
                        'nom_libre' => $nom,
                        'equipe_id' => null,
                        'joueur_id' => null,
                        'minute' => $minute,
                        'equipe_libre_nom' => $rencontre->equipe1_libre,
                    ]);
                }
            }
        }
        // Ajout buteurs équipe 2 (championnat)
        if ($request->has('buteurs_equipe2')) {
            foreach ($request->buteurs_equipe2 as $index => $joueur_id) {
                $minute = $request->minutes_buteurs_equipe2[$index] ?? null;
                if ($joueur_id && $minute !== null) {
                    $rencontre->buts()->create([
                        'joueur_id' => $joueur_id,
                        'equipe_id' => $rencontre->equipe2_id,
                        'minute' => $minute
                    ]);
                }
            }
        }
        // Ajout buteurs équipe 2 (libre)
        if ($request->has('buteurs_equipe2_libre')) {
            foreach ($request->buteurs_equipe2_libre as $index => $nom) {
                $minute = $request->minutes_buteurs_equipe2_libre[$index] ?? null;
                if ($nom && $minute !== null) {
                    $rencontre->buts()->create([
                        'nom_libre' => $nom,
                        'equipe_id' => null,
                        'joueur_id' => null,
                        'minute' => $minute,
                        'equipe_libre_nom' => $rencontre->equipe2_libre,
                    ]);
                }
            }
        }
        // Ajout cartons équipe 1 (championnat)
        if ($request->has('cartons_equipe1')) {
            foreach ($request->cartons_equipe1 as $index => $joueur_id) {
                $minute = $request->minutes_cartons_equipe1[$index] ?? null;
                $type = $request->type_cartons_equipe1[$index] ?? 'jaune';
                if ($joueur_id && $minute !== null) {
                    $rencontre->cartons()->create([
                        'joueur_id' => $joueur_id,
                        'equipe_id' => $rencontre->equipe1_id,
                        'minute' => $minute,
                        'type' => $type
                    ]);
                }
            }
        }
        // Ajout cartons équipe 1 (libre)
        if ($request->has('cartons_equipe1_libre')) {
            foreach ($request->cartons_equipe1_libre as $index => $nom) {
                $minute = $request->minutes_cartons_equipe1_libre[$index] ?? null;
                $type = $request->type_cartons_equipe1_libre[$index] ?? 'jaune';
                if ($nom && $minute !== null) {
                    $rencontre->cartons()->create([
                        'nom_libre' => $nom,
                        'equipe_id' => null,
                        'minute' => $minute,
                        'type' => $type,
                        'equipe_libre_nom' => $rencontre->equipe1_libre,
                    ]);
                }
            }
        }
        // Ajout cartons équipe 2 (championnat)
        if ($request->has('cartons_equipe2')) {
            foreach ($request->cartons_equipe2 as $index => $joueur_id) {
                $minute = $request->minutes_cartons_equipe2[$index] ?? null;
                $type = $request->type_cartons_equipe2[$index] ?? 'jaune';
                if ($joueur_id && $minute !== null) {
                    $rencontre->cartons()->create([
                        'joueur_id' => $joueur_id,
                        'equipe_id' => $rencontre->equipe2_id,
                        'minute' => $minute,
                        'type' => $type
                    ]);
                }
            }
        }
        // Ajout cartons équipe 2 (libre)
        if ($request->has('cartons_equipe2_libre')) {
            foreach ($request->cartons_equipe2_libre as $index => $nom) {
                $minute = $request->minutes_cartons_equipe2_libre[$index] ?? null;
                $type = $request->type_cartons_equipe2_libre[$index] ?? 'jaune';
                if ($nom && $minute !== null) {
                    $rencontre->cartons()->create([
                        'nom_libre' => $nom,
                        'equipe_id' => null,
                        'minute' => $minute,
                        'type' => $type,
                        'equipe_libre_nom' => $rencontre->equipe2_libre,
                    ]);
                }
            }
        }

        // Gestion MVP
        // On ne retient qu'un seul MVP (id ou nom libre)
        $mvp_id = $request->input('mvp_equipe1_id') ?: $request->input('mvp_equipe2_id');
        $mvp_libre = $request->input('mvp_equipe1_libre') ?: $request->input('mvp_equipe2_libre');
        if ($mvp_id) {
            $rencontre->mvp_id = $mvp_id;
            $rencontre->mvp_libre = null;
        } elseif ($mvp_libre) {
            $rencontre->mvp_id = null;
            $rencontre->mvp_libre = $mvp_libre;
        } else {
            $rencontre->mvp_id = null;
            $rencontre->mvp_libre = null;
        }
        // Enregistrer l'auteur de la modification
        $rencontre->updated_by = auth()->id();
        $rencontre->save();

        return redirect()->route('admin.rencontres.index')->with('success', 'Résultat mis à jour avec succès.');
    }

    /**
     * Réinitialise les résultats d'une rencontre (scores, buteurs, cartons)
     */
    public function resetResultat($id)
    {
        $rencontre = Rencontre::findOrFail($id);
        $rencontre->score_equipe1 = null;
        $rencontre->score_equipe2 = null;
        $rencontre->mvp_id = null;
        $rencontre->mvp_libre = null;
        $rencontre->mvp_libre_equipe = null;
        $rencontre->buts()->delete();
        $rencontre->cartons()->delete();
        $rencontre->save();
        return redirect()->back()->with('success', 'Les résultats de la rencontre ont été supprimés.');
    }

    /**
     * Affiche le formulaire de génération du calendrier pour les pools de la saison ouverte
     */
    public function genererForm()
    {
        // Utiliser la saison active (helper) si aucune saison 'ouverte' n'existe
        $saison = \App\Helpers\SaisonHelper::getActiveSaison();
        $pools = $saison ? \App\Models\Pool::where('saison_id', $saison->id)->get() : collect();
        return view('admin.rencontres.generer', compact('pools', 'saison'));
    }

    public function export(Request $request)
    {
        // Même logique de filtre que index
        $query = Rencontre::with(['equipe1', 'equipe2', 'pool', 'mvp']);
        if ($request->filled('pool_id')) {
            $query->where('pool_id', $request->pool_id);
        }
        if ($request->filled('equipe_id')) {
            $query->where(function($q) use ($request) {
                $q->where('equipe1_id', $request->equipe_id)
                  ->orWhere('equipe2_id', $request->equipe_id);
            });
        }
        if ($request->filled('journee')) {
            $query->where('journee', $request->journee);
        }
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
        }
        if ($request->filled('type_rencontre')) {
            $query->where('type_rencontre', $request->type_rencontre);
        }
        if ($request->filled('etat_match')) {
            if ($request->etat_match === 'joue') {
                $query->whereNotNull('score_equipe1')->whereNotNull('score_equipe2');
            } elseif ($request->etat_match === 'non_joue') {
                $query->whereNull('score_equipe1')->orWhereNull('score_equipe2');
            }
        }
        $rencontres = $query->orderBy('date')->get();
        return Excel::download(new RencontresExport($rencontres), 'rencontres.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Rencontre::with(['equipe1', 'equipe2', 'pool', 'mvp', 'matchEffectifs.joueurs.joueur']);
        if ($request->filled('pool_id')) {
            $query->where('pool_id', $request->pool_id);
        }
        if ($request->filled('equipe_id')) {
            $query->where(function($q) use ($request) {
                $q->where('equipe1_id', $request->equipe_id)
                  ->orWhere('equipe2_id', $request->equipe_id);
            });
        }
        if ($request->filled('journee')) {
            $query->where('journee', $request->journee);
        }
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
        }
        if ($request->filled('type_rencontre')) {
            $query->where('type_rencontre', $request->type_rencontre);
        }
        if ($request->filled('etat_match')) {
            if ($request->etat_match === 'joue') {
                $query->whereNotNull('score_equipe1')->whereNotNull('score_equipe2');
            } elseif ($request->etat_match === 'non_joue') {
                $query->whereNull('score_equipe1')->orWhereNull('score_equipe2');
            }
        }
        $rencontres = $query->orderBy('date')->get();
        $pdf = Pdf::loadView('exports.rencontres_pdf', ['rencontres' => $rencontres]);
        return $pdf->download('rencontres.pdf');
    }

    public function show($id)
    {
        $rencontre = \App\Models\Rencontre::with(['equipe1', 'equipe2', 'pool', 'buts.joueur', 'cartons.joueur', 'mvp', 'equipe1.joueurs', 'equipe2.joueurs', 'updatedBy'])->findOrFail($id);
        return view('admin.rencontres.show', compact('rencontre'));
    }
}
