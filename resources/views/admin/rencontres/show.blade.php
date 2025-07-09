@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4 max-w-4xl">
    <div class="bg-bl-card rounded-xl shadow-lg p-6 mb-6 border border-bl-border">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
            <div class="flex items-center gap-4">
                <div class="flex flex-col items-center">
                    @if($rencontre->equipe1)
                        <x-team-logo :team="$rencontre->equipe1" size="64" />
                    @elseif($rencontre->equipe1_libre)
                        <x-team-logo :team="(object)['nom'=>$rencontre->equipe1_libre]" size="64" />
                    @else
                        <x-team-logo :team="null" size="64" />
                    @endif
                    @if($rencontre->equipe1 || $rencontre->equipe1_libre)
                        <span class="mt-2 font-semibold text-white">{{ $rencontre->equipe1->nom ?? $rencontre->equipe1_libre }}</span>
                    @else
                        <span class="mt-2 text-gray-400">Non renseigné</span>
                    @endif
                </div>
                <div class="flex flex-col items-center mx-4">
                    <span class="text-3xl font-extrabold text-white bg-bl-accent px-4 py-2 rounded-lg shadow">{{ $rencontre->score_equipe1 ?? '-' }} <span class="text-lg">-</span> {{ $rencontre->score_equipe2 ?? '-' }}</span>
                    <span class="text-xs text-gray-400 mt-1">{{ $rencontre->type_rencontre ? ucfirst($rencontre->type_rencontre) : '' }}</span>
                </div>
                <div class="flex flex-col items-center">
                    @if($rencontre->equipe2)
                        <x-team-logo :team="$rencontre->equipe2" size="64" />
                    @elseif($rencontre->equipe2_libre)
                        <x-team-logo :team="(object)['nom'=>$rencontre->equipe2_libre]" size="64" />
                    @else
                        <x-team-logo :team="null" size="64" />
                    @endif
                    @if($rencontre->equipe2 || $rencontre->equipe2_libre)
                        <span class="mt-2 font-semibold text-white">{{ $rencontre->equipe2->nom ?? $rencontre->equipe2_libre }}</span>
                    @else
                        <span class="mt-2 text-gray-400">Non renseigné</span>
                    @endif
                </div>
            </div>
            <div class="text-right">
                <div class="text-gray-400 mb-1">{{ $rencontre->date }} à {{ \Carbon\Carbon::parse($rencontre->heure)->format('H:i') }}</div>
                <div class="text-gray-400 mb-1">Stade : {{ $rencontre->stade }}</div>
                @if($rencontre->pool)
                    <div class="text-gray-400 text-sm">Poule : {{ $rencontre->pool->nom }}</div>
                @endif
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center mb-4">
            <div class="bg-bl-card border border-bl-border text-white rounded-lg px-4 py-2 text-center">
                <div class="font-bold text-lg">Homme du match</div>
                <div>
                    @if($rencontre->mvp)
                        {{ $rencontre->mvp->nom }} {{ $rencontre->mvp->prenom }}
                        <span class="text-xs">
                            (
                            {{ $rencontre->mvp->equipe->nom ?? $rencontre->mvp->equipe_libre_nom ?? 'Équipe inconnue' }}
                            )
                        </span>
                    @elseif($rencontre->mvp_libre)
                        <span class="italic">{{ $rencontre->mvp_libre }}</span>
                    @else
                        <span class="text-gray-400">Non attribué</span>
                    @endif
                </div>
            </div>
        </div>
        <!-- Résultat action buttons -->
        <div class="flex gap-4 mb-6">
            <a href="{{ url('/admin/matchs/' . $rencontre->id . '/resultat') }}" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 border border-yellow-500 transition">Saisir/Modifier résultats</a>
            <form action="{{ url('/admin/matchs/' . $rencontre->id . '/reset-resultat') }}" method="POST" onsubmit="return confirm('Supprimer le résultat de cette rencontre ?');">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">Supprimer résultats</button>
            </form>
        </div>
        <!-- Effectifs section -->
        <div class="bg-bl-card rounded-xl shadow-lg p-6 mb-6 border border-bl-border">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach([$rencontre->equipe1, $rencontre->equipe2] as $equipe)
                    @if($equipe)
                        @php
                            $effectif = \App\Models\MatchEffectif::where('rencontre_id', $rencontre->id)->where('equipe_id', $equipe->id)->first();
                        @endphp
                        <div>
                            <div class="font-bold text-white uppercase text-base mb-2">Effectif {{ $equipe->nom }}</div>
                            @if($effectif)
                                <div class="mb-2">
                                    <span class="font-semibold text-blue-500">Titulaires :</span>
                                    <ul class="text-white text-sm space-y-1 mt-1">
                                        @foreach($effectif->joueurs->where('type', 'titulaire')->sortBy('ordre') as $titulaire)
                                            <li>
                                                <span class="inline-block bg-gray-700 text-[#6fcf97] font-bold rounded px-2 py-0.5 mr-2 text-xs align-middle">{{ $titulaire->joueur->numero_dossard ?? '-' }}</span>
                                                {{ $titulaire->joueur->nom ?? '-' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="mb-2">
                                    <span class="font-semibold text-yellow-500">Remplaçants :</span>
                                    <ul class="text-white text-sm space-y-1 mt-1">
                                        @foreach($effectif->joueurs->where('type', 'remplaçant')->sortBy('ordre') as $remplacant)
                                            <li>
                                                <span class="inline-block bg-gray-700 text-yellow-400 font-bold rounded px-2 py-0.5 mr-2 text-xs align-middle">{{ $remplacant->joueur->numero_dossard ?? '-' }}</span>
                                                {{ $remplacant->joueur->nom ?? '-' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div>
                                    <span class="font-semibold text-green-500">Remplacements :</span>
                                    <ul class="text-white text-sm space-y-1 mt-1">
                                        @forelse($effectif->remplacements as $remp)
                                            <li>
                                                <span class="inline-block bg-gray-700 text-yellow-400 font-bold rounded px-2 py-0.5 mr-2 text-xs align-middle">{{ $remp->remplaçant->numero_dossard ?? '-' }}</span>
                                                <span class="font-bold">{{ $remp->remplaçant->nom ?? '-' }}</span>
                                                @if(!is_null($remp->minute))
                                                    <span class="text-xs text-gray-400">{{ $remp->minute }}'</span>
                                                @endif
                                                <span class="text-xs">a remplacé</span>
                                                <span class="inline-block bg-gray-700 text-blue-400 font-bold rounded px-2 py-0.5 mx-2 text-xs align-middle">{{ $remp->remplacé->numero_dossard ?? '-' }}</span>
                                                <span class="font-bold">{{ $remp->remplacé->nom ?? '-' }}</span>
                                            </li>
                                        @empty
                                            <li class="text-gray-500">Aucun remplacement</li>
                                        @endforelse
                                    </ul>
                                </div>
                            @else
                                <div class="text-gray-400 italic">Aucun effectif saisi</div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
            {{-- Boutons d'action réservés aux admins, à ajouter ici si besoin --}}
        </div>
        <div class="flex gap-4 mb-6">
            <a href="{{ route('admin.rencontres.edit', $rencontre) }}" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 border border-yellow-500 transition">Modifier</a>
            <form action="{{ route('admin.rencontres.destroy', $rencontre) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cette rencontre ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">Supprimer</button>
            </form>
            <a href="{{ route('admin.rencontres.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow border border-yellow-500 ml-auto transition">← Retour à la liste</a>
        </div>
    </div>
    <!-- Section infos match comme la fiche publique -->
    <div class="bg-bl-card rounded-xl shadow-lg border-b-4 border-bl-accent mb-6 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex-1">
                <div class="font-bold text-white uppercase text-sm mb-1">Buteurs</div>
                <ul class="text-white text-sm space-y-1">
                    @foreach($rencontre->buts as $but)
                        <li>
                            @if($but->joueur)
                                <span class="font-bold">{{ $but->joueur?->nom }} {{ $but->joueur?->prenom }}</span>
                            @elseif($but->nom_libre)
                                <span class="italic font-bold">{{ $but->nom_libre }}</span>
                            @endif
                            <span class="text-xs text-gray-400">{{ $but->minute ? $but->minute . "'" : '' }}</span>
                            <span class="text-xs text-gray-400">
                                @if($but->equipe_id == $rencontre->equipe1?->id)
                                    {{ $rencontre->equipe1?->nom }}
                                @elseif($but->equipe_id == $rencontre->equipe2?->id)
                                    {{ $rencontre->equipe2?->nom }}
                                @elseif($but->equipe_libre_nom)
                                    {{ $but->equipe_libre_nom }}
                                @endif
                            </span>
                        </li>
                    @endforeach
                    @if($rencontre->buts->isEmpty())
                        <li class="text-gray-500">Aucun but</li>
                    @endif
                </ul>
            </div>
            <div class="flex-1">
                <div class="font-bold text-white uppercase text-sm mb-1">Cartons</div>
                <ul class="text-white text-sm space-y-1">
                    @foreach($rencontre->cartons as $carton)
                        <li>
                            @if($carton->joueur)
                                <span class="font-bold">{{ $carton->joueur?->nom }} {{ $carton->joueur?->prenom }}</span>
                            @elseif($carton->nom_libre)
                                <span class="italic font-bold">{{ $carton->nom_libre }}</span>
                            @endif
                            <span class="text-xs text-gray-400">{{ $carton->minute ? $carton->minute . "'" : '' }}</span>
                            <span class="text-xs {{ $carton->type == 'jaune' ? 'text-yellow-400' : 'text-white' }}">{{ ucfirst($carton->type) }}</span>
                            <span class="text-xs text-gray-400 ml-2">
                                @if($carton->equipe_id == $rencontre->equipe1?->id)
                                    ({{ $rencontre->equipe1?->nom }})
                                @elseif($carton->equipe_id == $rencontre->equipe2?->id)
                                    ({{ $rencontre->equipe2?->nom }})
                                @elseif($carton->equipe_libre_nom)
                                    ({{ $carton->equipe_libre_nom }})
                                @endif
                            </span>
                        </li>
                    @endforeach
                    @if($rencontre->cartons->isEmpty())
                        <li class="text-gray-500">Aucun carton</li>
                    @endif
                </ul>
            </div>
            <div class="flex-1">
                <div class="font-bold text-white uppercase text-sm mb-1">Homme du match</div>
                <div class="text-white text-lg font-extrabold">
                    @if($rencontre->mvp)
                        {{ $rencontre->mvp->nom }} {{ $rencontre->mvp->prenom }}
                        <span class="text-xs text-gray-400">
                            (
                            @if($rencontre->mvp->equipe?->nom)
                                {{ $rencontre->mvp->equipe->nom }}
                            @elseif($rencontre->mvp_libre_equipe)
                                {{ $rencontre->mvp_libre_equipe }}
                            @else
                                Équipe inconnue
                            @endif
                            )
                        </span>
                    @elseif($rencontre->mvp_libre)
                        {{ $rencontre->mvp_libre }}
                        <span class="text-xs text-gray-400">
                            (
                            {{ $rencontre->mvp_libre_equipe ?? 'Équipe inconnue' }}
                            )
                        </span>
                    @else
                        -
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-4 text-xs text-gray-400 text-right">
            @if($rencontre->updatedBy)
                <span>Dernière modification par : <span class="font-bold">{{ $rencontre->updatedBy->name }}</span> le {{ $rencontre->updated_at ? $rencontre->updated_at->format('d/m/Y à H:i') : '' }}</span>
            @endif
        </div>
    </div>
</div>
@endsection
