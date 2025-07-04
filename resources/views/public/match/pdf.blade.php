<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Feuille de match</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        .header { text-align: center; font-weight: bold; font-size: 20px; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .table th, .table td { border: 1px solid #333; padding: 5px; text-align: left; }
        .table th { background: #eee; }
    </style>
</head>
<body>
    <div class="header">Feuille de match</div>
    <div class="section">
        <strong>Match :</strong> {{ $rencontre->equipe1->nom }} vs {{ $rencontre->equipe2->nom }}<br>
        <strong>Date :</strong> {{ $rencontre->date }}<br>
        <strong>Heure :</strong> {{ $rencontre->heure }}<br>
        <strong>Stade :</strong> {{ $rencontre->stade }}<br>
        <strong>Journée :</strong> {{ $rencontre->journee }}<br>
        <strong>Pool :</strong> {{ $rencontre->pool?->nom ?? '-' }}<br>
    </div>
    <div class="section">
        <strong>Score :</strong> {{ $rencontre->score_equipe1 ?? '-' }} - {{ $rencontre->score_equipe2 ?? '-' }}
    </div>
    <div class="section">
        <strong>Buteurs :</strong>
        <ul>
            @forelse($rencontre->buts as $but)
                <li>{{ $but->joueur?->nom }} {{ $but->joueur?->prenom }} ({{ $but->minute }}') -
                    @if($but->equipe_id == $rencontre->equipe1?->id)
                        {{ $rencontre->equipe1?->nom }}
                    @elseif($but->equipe_id == $rencontre->equipe2?->id)
                        {{ $rencontre->equipe2?->nom }}
                    @elseif($but->equipe_libre_nom)
                        {{ $but->equipe_libre_nom }}
                    @else
                        Équipe inconnue
                    @endif
                </li>
            @empty
                <li>Aucun</li>
            @endforelse
        </ul>
    </div>
    <div class="section">
        <strong>Cartons :</strong>
        <ul>
            @forelse($rencontre->cartons as $carton)
                <li>{{ $carton->joueur?->nom }} {{ $carton->joueur?->prenom }} ({{ $carton->minute }}') - {{ ucfirst($carton->type) }} -
                    @if($carton->equipe_id == $rencontre->equipe1?->id)
                        {{ $rencontre->equipe1?->nom }}
                    @elseif($carton->equipe_id == $rencontre->equipe2?->id)
                        {{ $rencontre->equipe2?->nom }}
                    @elseif($carton->equipe_libre_nom)
                        {{ $carton->equipe_libre_nom }}
                    @else
                        Équipe inconnue
                    @endif
                </li>
            @empty
                <li>Aucun</li>
            @endforelse
        </ul>
    </div>
    <div class="section">
        <strong>Homme du match :</strong>
        @if($rencontre->mvp)
            {{ $rencontre->mvp->nom }} {{ $rencontre->mvp->prenom }}
            (
            @if($rencontre->mvp->equipe?->nom)
                {{ $rencontre->mvp->equipe->nom }}
            @elseif($rencontre->mvp_libre_equipe)
                {{ $rencontre->mvp_libre_equipe }}
            @else
                Équipe inconnue
            @endif
            )
        @elseif($rencontre->mvp_libre)
            {{ $rencontre->mvp_libre }} ({{ $rencontre->mvp_libre_equipe ?? 'Équipe inconnue' }})
        @else
            -
        @endif
    </div>
    <div class="section">
        <strong>Effectifs :</strong>
        <div style="display: flex; gap: 40px;">
            @php
                $effectifs = $rencontre->matchEffectifs ?? collect();
            @endphp
            @foreach([$rencontre->equipe1, $rencontre->equipe2] as $equipe)
                @php
                    $effectif = $effectifs->where('equipe_id', $equipe->id)->first();
                    $joueurs = $effectif && $effectif->joueurs ? $effectif->joueurs : collect();
                    $remplacements = $effectif && $effectif->remplacements ? $effectif->remplacements : collect();
                @endphp
                <div style="min-width: 260px;">
                    <div style="font-weight:bold; color:#e2001a; margin-bottom:4px;">{{ $equipe->nom }}</div>
                    @if(!$effectif)
                        <div style="color:#888; font-style:italic; margin-bottom:12px;">Aucun effectif saisi pour cette équipe.</div>
                    @else
                        <div style="margin-bottom:2px; text-decoration:underline;">Titulaires</div>
                        <ul style="margin-bottom:6px;">
                            @foreach($joueurs->where('type','titulaire') as $effJoueur)
                                <li>
                                    N°{{ $effJoueur->joueur?->numero_dossard ?? '-' }}
                                    {{ $effJoueur->joueur?->nom }} {{ $effJoueur->joueur?->prenom }}
                                </li>
                            @endforeach
                        </ul>
                        <div style="margin-bottom:2px; text-decoration:underline;">Remplaçants</div>
                        <ul style="margin-bottom:6px;">
                            @foreach($joueurs->where('type','remplacant') as $effJoueur)
                                <li>
                                    N°{{ $effJoueur->joueur?->numero_dossard ?? '-' }}
                                    {{ $effJoueur->joueur?->nom }} {{ $effJoueur->joueur?->prenom }}
                                </li>
                            @endforeach
                        </ul>
                        <div style="margin-bottom:2px; text-decoration:underline;">Remplacements</div>
                        <ul>
                            @foreach($remplacements as $remp)
                                <li>
                                    N°{{ $remp->remplaçant?->numero_dossard ?? '-' }} {{ $remp->remplaçant?->nom }} {{ $remp->remplaçant?->prenom }}
                                    &rarr; N°{{ $remp->remplacé?->numero_dossard ?? '-' }} {{ $remp->remplacé?->nom }} {{ $remp->remplacé?->prenom }}
                                    ({{ $remp->minute }}')
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div style="margin-top:40px; text-align:center;">
        <div style="font-size:13px; font-weight:bold; letter-spacing:2px; color:#e2001a; border-top:2px dashed #e2001a; width:60%; margin:0 auto 8px auto; padding-top:8px;">
            Comité exécutif
        </div>
        <div style="font-size:11px; color:#888;">Signature officielle</div>
        <div style="margin: 8px auto 0 auto; width: 120px; height: 40px;">
            <!-- Signature SVG stylisée -->
            <svg viewBox="0 0 120 40" width="120" height="40">
                <path d="M10,30 Q30,10 50,30 Q70,50 110,10" stroke="#222" stroke-width="2" fill="none"/>
                <text x="60" y="35" text-anchor="middle" font-size="12" fill="#444" font-family="cursive">EUFLU</text>
            </svg>
        </div>
        @if($rencontre->updatedBy)
            <div style="font-size:11px; color:#888; margin-top:8px;">Dernière modification par : <span style="font-weight:bold;">{{ $rencontre->updatedBy->name }}</span></div>
        @endif
        <div style="margin-top:18px; font-size:10px; color:#aaa; letter-spacing:1px;">
            Document généré automatiquement - toute falsification est interdite. QR code ou filigrane possible sur demande.
        </div>
    </div>
    <style>
        body { background: repeating-linear-gradient(135deg, #f8f8f8, #f8f8f8 20px, #e2001a10 22px, #f8f8f8 40px); }
        .header { text-shadow: 1px 1px 0 #e2001a, 2px 2px 0 #fff; letter-spacing: 2px; }
        .section strong { color: #e2001a; }
        ul { list-style: square inside; }
        li { margin-bottom: 2px; }
    </style>
</body>
</html>
