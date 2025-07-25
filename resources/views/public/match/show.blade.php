@extends('layouts.public')
@section('title', 'Fiche du match')
@section('content')
<div class="max-w-4xl mx-auto mt-10 mb-8">
    <div class="bg-[#23272a] rounded-xl shadow-lg border-b-4 border-[#6fcf97]">
        <div class="flex items-center justify-between px-6 pt-6">
            <a href="{{ url()->previous() }}" class="text-[#6fcf97] font-bold text-sm hover:underline flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                Journée {{ $rencontre->journee ?? '-' }}
            </a>
            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider">{{ $rencontre->stade ?? '' }}</div>
        </div>
        <div class="text-center text-2xl font-extrabold text-white uppercase tracking-wider mt-2">HIGHLIGHTS</div>
        <div class="flex flex-col md:flex-row items-center justify-between px-6 py-6 gap-6">
            <div class="flex-1 flex flex-col items-center">
                <span class="text-white text-lg font-extrabold uppercase mb-2">{{ $rencontre->equipe1->nom ?? $rencontre->equipe1_libre ?? '-' }}</span>
                <x-team-logo :team="$rencontre->equipe1" size="56" />
                @if($rencontre->equipe1 && $rencontre->equipe1->coach)
                    <span class="text-xs text-gray-400 mt-1">Coach : {{ $rencontre->equipe1->coach }}</span>
                @endif
            </div>
            <div class="flex flex-col items-center justify-center">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-black text-white px-4 py-2 rounded text-3xl font-extrabold tracking-widest border-2 border-[#23272a]">{{ $rencontre->score_equipe1 ?? '-' }}</span>
                    <span class="text-white text-2xl font-extrabold">-</span>
                    <span class="bg-[#e2001a] text-white px-4 py-2 rounded text-3xl font-extrabold tracking-widest border-2 border-[#e2001a]">{{ $rencontre->score_equipe2 ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-center gap-2">
                    <span class="text-xs text-gray-400 uppercase font-bold">FINAL</span>
                </div>
            </div>
            <div class="flex-1 flex flex-col items-center">
                <span class="text-white text-lg font-extrabold uppercase mb-2">{{ $rencontre->equipe2->nom ?? $rencontre->equipe2_libre ?? '-' }}</span>
                <x-team-logo :team="$rencontre->equipe2" size="56" />
                @if($rencontre->equipe2 && $rencontre->equipe2->coach)
                    <span class="text-xs text-gray-400 mt-1">Coach : {{ $rencontre->equipe2->coach }}</span>
                @endif
            </div>
        </div>
        <div class="flex items-center justify-between px-6 pb-2">
            <div></div>
            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider">{{ $rencontre->date }} à {{ \Carbon\Carbon::parse($rencontre->heure)->format('H:i') }}</div>
        </div>
        <div class="bg-[#181d1f] px-6 py-4 rounded-b-xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <div class="font-bold text-[#6fcf97] uppercase text-sm mb-1">Buteurs</div>
                    <ul class="text-white text-sm space-y-1">
                        @foreach($rencontre->buts as $but)
                            <li>
                                <span class="font-bold">{{ $but->joueur?->nom }} {{ $but->joueur?->prenom }}</span>
                                <span class="text-xs text-gray-400">{{ $but->minute ? $but->minute . "'" : '' }}</span>
                                <span class="text-xs text-gray-400">{{ $but->equipe_id == $rencontre->equipe1?->id ? $rencontre->equipe1?->nom : $rencontre->equipe2?->nom }}</span>
                            </li>
                        @endforeach
                        @if($rencontre->buts->isEmpty())
                            <li class="text-gray-500">Aucun but</li>
                        @endif
                    </ul>
                </div>
                <div class="flex-1">
                    <div class="font-bold text-[#e2001a] uppercase text-sm mb-1">Cartons</div>
                    <ul class="text-white text-sm space-y-1">
                        @foreach($rencontre->cartons as $carton)
                            <li>
                                <span class="font-bold">{{ $carton->joueur?->nom }} {{ $carton->joueur?->prenom }}</span>
                                <span class="text-xs text-gray-400">{{ $carton->minute ? $carton->minute . "'" : '' }}</span>
                                <span class="text-xs {{ $carton->type == 'jaune' ? 'text-yellow-400' : 'text-red-500' }}">{{ ucfirst($carton->type) }}</span>
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
                    <div class="font-bold text-[#6fcf97] uppercase text-sm mb-1">Homme du match</div>
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
                    <span>Dernière modification par : <span class="font-bold">{{ $rencontre->updatedBy->name }}</span></span>
                @endif
            </div>
        </div>
    </div>
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('public.matchs.index') }}" class="text-[#6fcf97] font-bold text-sm hover:underline flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Retour à la liste des matchs
        </a>
    </div>
    <div class="flex justify-center mt-8">
        <a href="{{ route('public.match.pdf', ['id' => $rencontre->id]) }}" class="px-8 py-3 bg-[#23272a] border-2 border-[#6fcf97] text-white font-bold rounded hover:bg-[#6fcf97] hover:text-[#23272a] transition" target="_blank">Télécharger la feuille de match (PDF)</a>
    </div>
    <div class="bg-[#181d1f] px-6 py-4 rounded-b-xl mt-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach([$rencontre->equipe1, $rencontre->equipe2] as $equipe)
                @if($equipe)
                    @php
                        $effectif = \App\Models\MatchEffectif::where('rencontre_id', $rencontre->id)->where('equipe_id', $equipe->id)->first();
                    @endphp
                    <div>
                        <div class="font-bold text-[#6fcf97] uppercase text-base mb-2">Effectif {{ $equipe->nom }}</div>
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
    </div>
    <div class="mt-4 text-xs text-gray-500 text-right">
        @if($rencontre->updated_at)
            <span>Dernière modification le {{ $rencontre->updated_at->format('d/m/Y à H:i') }}</span>
        @endif
    </div>
</div>
@endsection
