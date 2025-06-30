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
            <h3 class="font-semibold mb-2">Effectif</h3>
            <ul class="mb-4">
                @forelse($equipe->joueurs as $joueur)
                    <li>
                        <a href="{{ route('public.joueur.show', $joueur) }}" class="text-blue-600 hover:underline">{{ $joueur->nom }} {{ $joueur->prenom }}</a>
                    </li>
                @empty
                    <li class="text-gray-400">Aucun joueur</li>
                @endforelse
            </ul>
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
