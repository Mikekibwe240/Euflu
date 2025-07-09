@extends('layouts.admin')

@section('title', "CLASSEMENTS D'EQUIPES")

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8 text-center text-white">CLASSEMENTS D'EQUIPES</h1>
    <div class="mb-4 text-center text-lg font-semibold text-white">
        Saison active :
        <span class="font-bold">{{ $selectedSaison?->nom ?? $selectedSaison?->annee ?? 'Aucune' }}</span>
    </div>
    <form method="GET" action="" class="mb-6 flex flex-wrap gap-2 items-center justify-center bg-bl-card p-4 rounded-lg shadow border border-bl-border">
        <label for="saison_id" class="font-semibold text-gray-200">Filtrer par saison :</label>
        <select name="saison_id" id="saison_id" class="border border-bl-border rounded px-2 py-1 bg-gray-800 text-white" onchange="this.form.submit()">
            <option value="">Actuelle</option>
            @foreach($saisons as $s)
                <option value="{{ $s->id }}" @if(request('saison_id', $selectedSaison?->id) == $s->id) selected @endif>{{ $s->nom ?? $s->annee }}</option>
            @endforeach
        </select>
        <label for="pool" class="font-semibold ml-4 text-gray-200">Filtrer par pool :</label>
        <select name="pool" id="pool" class="border border-bl-border rounded px-2 py-1 bg-gray-800 text-white" onchange="this.form.submit()">
            <option value="">Tous les pools</option>
            @foreach($pools as $p)
                <option value="{{ $p->nom }}" @if(request('pool', $selectedPool) == $p->nom) selected @endif>Pool {{ $p->nom }}</option>
            @endforeach
        </select>
    </form>
    <div class="space-y-12">
        @foreach($pools as $pool)
            @php
                // Afficher toutes les équipes du pool même sans stats
                $classement = $pool->equipes->map(function($eq) use ($selectedSaison) {
                    $stats = $eq->statsSaison($selectedSaison?->id)->first();
                    return (object) [
                        'equipe' => $eq,
                        'mj' => ($stats?->victoires ?? 0) + ($stats?->nuls ?? 0) + ($stats?->defaites ?? 0),
                        'mg' => $stats?->victoires ?? 0,
                        'mp' => $stats?->defaites ?? 0,
                        'mn' => $stats?->nuls ?? 0,
                        'bp' => $stats?->buts_pour ?? 0,
                        'bc' => $stats?->buts_contre ?? 0,
                        'gd' => ($stats?->buts_pour ?? 0) - ($stats?->buts_contre ?? 0),
                        'points' => $stats?->points ?? 0,
                        'qualifie' => $stats?->qualifie ?? false,
                        'relegue' => $stats?->relegue ?? false,
                    ];
                })->sortByDesc('points')->sortByDesc('gd')->sortByDesc('bp')->values();
            @endphp
            <div class="bg-bl-card border border-bl-border rounded-xl shadow-lg p-6 mb-8">
                <div class="flex flex-wrap gap-4 mb-4 items-center justify-between">
                    <h2 class="text-2xl font-bold text-white">Pool {{ $pool->nom }}</h2>
                    <div class="flex flex-wrap gap-2">
                        <div class="bg-green-900 text-green-400 px-4 py-2 rounded-xl flex flex-col items-center min-w-[90px] border border-green-700">
                            <span class="font-bold text-lg">{{ $classement->where('qualifie', true)->count() }}</span>
                            <span class="text-xs font-semibold">Qualifiés</span>
                        </div>
                        <div class="bg-red-900 text-white px-4 py-2 rounded-xl flex flex-col items-center min-w-[90px] border border-red-700">
                            <span class="font-bold text-lg">{{ $classement->where('relegue', true)->count() }}</span>
                            <span class="text-xs font-semibold">Relégués</span>
                        </div>
                        <div class="bg-bl-card text-white px-4 py-2 rounded-xl flex flex-col items-center min-w-[90px] border border-bl-border">
                            <span class="font-bold text-lg">{{ $classement->count() }}</span>
                            <span class="text-xs font-semibold">Équipes</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-700 text-gray-200 text-xs font-semibold border border-bl-border">
                            Journées&nbsp;: <span class="ml-1 font-bold">{{ $classement->max('journee') ?? '-' }}</span>
                        </span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mb-4">
                    <div class="bg-bl-card border border-bl-border rounded-lg px-4 py-2 flex flex-col items-center min-w-[120px]">
                        <span class="font-bold text-lg text-white">Total buts</span>
                        <span class="text-xl font-bold">{{ $classement->sum('bp') }}</span>
                    </div>
                    <div class="bg-bl-card border border-bl-border rounded-lg px-4 py-2 flex flex-col items-center min-w-[120px]">
                        <span class="font-bold text-lg text-green-400">Total matchs</span>
                        <span class="text-xl font-bold">{{ $classement->sum('mj') }}</span>
                    </div>
                    <div class="bg-bl-card border border-bl-border rounded-lg px-4 py-2 flex flex-col items-center min-w-[120px]">
                        <span class="font-bold text-lg text-yellow-400">Ratio buts/match</span>
                        <span class="text-xl font-bold">{{ $classement->sum('mj') ? number_format($classement->sum('bp') / $classement->sum('mj'), 2) : '-' }}</span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mb-4">
                    <a href="{{ route('admin.classement_buteurs', ['pool' => $pool->id]) }}" class="bg-bl-accent text-white px-4 py-2 rounded shadow hover:bg-bl-dark hover:text-bl-accent border border-bl-accent transition">TOPS BUTEURS</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-bl-card text-white rounded-2xl shadow-lg text-center border border-bl-border">
                        <thead class="bg-[#23272a]">
                            <tr>
                                <th class="px-2 py-2 rounded-tl-2xl text-white">PL</th>
                                <th class="px-2 py-2 text-white">EQUIPES</th>
                                <th class="px-2 py-2 text-white">MJ</th>
                                <th class="px-2 py-2 text-white">MG</th>
                                <th class="px-2 py-2 text-white">MP</th>
                                <th class="px-2 py-2 text-white">MN</th>
                                <th class="px-2 py-2 text-white">BP</th>
                                <th class="px-2 py-2 text-white">BC</th>
                                <th class="px-2 py-2 text-white">GD</th>
                                <th class="px-2 py-2 text-white">PTS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classement as $index => $item)
                                <tr class="border-b border-bl-border hover:bg-bl-dark transition cursor-pointer" onclick="window.location='{{ route('admin.equipes.show', $item->equipe->id) }}'">
                                    <td class="px-2 py-2 font-bold text-white">{{ $index+1 }}</td>
                                    <td class="px-2 py-2 font-semibold text-white flex items-center gap-2">
                                        <x-team-logo :team="$item->equipe" :size="28" />
                                        <span>{{ $item->equipe->nom ?? '-' }}</span>
                                    </td>
                                    <td class="px-2 py-2 text-white">{{ $item->mj }}</td>
                                    <td class="px-2 py-2 text-white">{{ $item->mg }}</td>
                                    <td class="px-2 py-2 text-white">{{ $item->mp }}</td>
                                    <td class="px-2 py-2 text-white">{{ $item->mn }}</td>
                                    <td class="px-2 py-2 text-white">{{ $item->bp }}</td>
                                    <td class="px-2 py-2 text-white">{{ $item->bc }}</td>
                                    <td class="px-2 py-2 text-white">{{ $item->gd }}</td>
                                    <td class="px-2 py-2 font-bold text-white">{{ $item->points }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
