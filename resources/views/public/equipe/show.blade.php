@extends('layouts.public')
@section('content')
<div class="container mx-auto p-4">
    <div class="flex flex-col md:flex-row gap-8 items-start">
        <div>
            @if($equipe->logo)
                <img src="{{ asset('storage/' . $equipe->logo) }}" alt="Logo équipe" class="h-32 w-32 rounded-full object-cover mb-2">
            @else
                <div class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center mb-2">?</div>
            @endif
            <div class="text-lg font-bold">{{ $equipe->nom }}</div>
            <div class="text-gray-600">Pool : {{ $equipe->pool->nom ?? '-' }}</div>
            <div class="text-gray-600">Saison : {{ $equipe->saison->annee ?? '-' }}</div>
        </div>
        <div class="flex-1">
            <h2 class="text-xl font-semibold mb-2">Statistiques</h2>
            <ul class="mb-4">
                <li>Points : <span class="font-bold">{{ $stats->points ?? 0 }}</span></li>
                <li>Victoires : <span class="font-bold">{{ $stats->victoires ?? 0 }}</span></li>
                <li>Nuls : <span class="font-bold">{{ $stats->nuls ?? 0 }}</span></li>
                <li>Défaites : <span class="font-bold">{{ $stats->defaites ?? 0 }}</span></li>
                <li>Buts pour : <span class="font-bold">{{ $stats->buts_pour ?? 0 }}</span></li>
                <li>Buts contre : <span class="font-bold">{{ $stats->buts_contre ?? 0 }}</span></li>
                <li>Cartons jaunes : <span class="font-bold">{{ $stats->cartons_jaunes ?? 0 }}</span></li>
                <li>Cartons rouges : <span class="font-bold">{{ $stats->cartons_rouges ?? 0 }}</span></li>
            </ul>
            <h3 class="font-semibold mb-2">Joueurs de l'équipe</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse($equipe->joueurs as $joueur)
                    <div class="bg-[#181d1f] hover:bg-[#23272a] rounded-lg p-4 shadow transition cursor-pointer border border-[#23272a] flex items-center gap-4" onclick="window.location='{{ route('public.joueur.show', $joueur) }}'">
                        <div>
                            @if($joueur->photo)
                                <img src="{{ asset('storage/'.$joueur->photo) }}" alt="Photo" class="h-14 w-14 rounded-full object-cover bg-gray-700">
                            @else
                                <div class="h-14 w-14 rounded-full bg-gray-700 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-10 w-10">
                                        <circle cx="12" cy="8" r="4"/>
                                        <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-white text-lg">{{ $joueur->nom }} <span class="font-normal">{{ $joueur->prenom }}</span></div>
                            <div class="text-gray-400 text-sm uppercase">{{ $joueur->poste }}</div>
                            <div class="text-gray-400 text-xs mt-1 flex flex-col gap-0.5">
                                <span>Licence : <span class="font-mono">{{ $joueur->numero_licence ?? '-' }}</span></span>
                                <span>Dossard : <span class="font-mono">{{ $joueur->numero_dossard ?? '-' }}</span></span>
                                <span>Nationalité : {{ $joueur->nationalite ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-400 py-2">Aucun joueur</div>
                @endforelse
            </div>
            <h3 class="font-semibold mb-2">Matchs joués</h3>
            <ul>
                @forelse($rencontres as $r)
                    <li>
                        <a href="{{ route('public.match.show', $r) }}" class="text-blue-600 hover:underline">
                            {{ $r->equipe1->nom }} {{ $r->score_equipe1 ?? '-' }} - {{ $r->score_equipe2 ?? '-' }} {{ $r->equipe2->nom }}
                        </a>
                        <span class="text-gray-500">({{ $r->date }})</span>
                    </li>
                @empty
                    <li class="text-gray-400">Aucun match</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
