@extends('layouts.admin')

@section('title', "CLASSEMENTS D'EQUIPES")

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8 text-center text-blue-700 dark:text-blue-300">CLASSEMENTS D'EQUIPES</h1>
    <div class="mb-6 flex justify-start">
        <a href="/admin" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded shadow transition">&larr; Retour</a>
    </div>
    <form method="GET" action="" class="mb-6 flex flex-wrap gap-2 items-center justify-center">
        <label for="pool" class="font-semibold">Filtrer par pool :</label>
        <select name="pool" id="pool" class="border rounded px-2 py-1" onchange="this.form.submit()">
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
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 mb-8">
                <div class="flex flex-wrap gap-4 mb-4 items-center justify-between">
                    <h2 class="text-2xl font-bold text-blue-600 dark:text-blue-300">Pool {{ $pool->nom }}</h2>
                    <div class="flex flex-wrap gap-2">
                        <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-4 py-2 rounded-xl flex flex-col items-center min-w-[90px]">
                            <span class="font-bold text-lg">{{ $classement->where('qualifie', true)->count() }}</span>
                            <span class="text-xs font-semibold">Qualifiés</span>
                        </div>
                        <div class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-4 py-2 rounded-xl flex flex-col items-center min-w-[90px]">
                            <span class="font-bold text-lg">{{ $classement->where('relegue', true)->count() }}</span>
                            <span class="text-xs font-semibold">Relégués</span>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-4 py-2 rounded-xl flex flex-col items-center min-w-[90px]">
                            <span class="font-bold text-lg">{{ $classement->count() }}</span>
                            <span class="text-xs font-semibold">Équipes</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-semibold">
                            Journées&nbsp;: <span class="ml-1 font-bold">{{ $classement->max('journee') ?? '-' }}</span>
                        </span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mb-4">
                    <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg px-4 py-2 flex flex-col items-center min-w-[120px]">
                        <span class="font-bold text-lg text-blue-700 dark:text-blue-200">Total buts</span>
                        <span class="text-xl font-bold">{{ $classement->sum('bp') }}</span>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg px-4 py-2 flex flex-col items-center min-w-[120px]">
                        <span class="font-bold text-lg text-green-700 dark:text-green-200">Total matchs</span>
                        <span class="text-xl font-bold">{{ $classement->sum('mj') }}</span>
                    </div>
                    <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg px-4 py-2 flex flex-col items-center min-w-[120px]">
                        <span class="font-bold text-lg text-yellow-700 dark:text-yellow-200">Ratio buts/match</span>
                        <span class="text-xl font-bold">{{ $classement->sum('mj') ? number_format($classement->sum('bp') / $classement->sum('mj'), 2) : '-' }}</span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mb-4">
                    <a href="{{ route('admin.classement_buteurs', ['pool' => $pool->id]) }}" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 transition">TOPS BUTEURS</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-900 rounded-2xl shadow-lg text-center border border-gray-200 dark:border-gray-700">
                        <thead class="bg-gradient-to-r from-blue-200 via-blue-100 to-blue-50 dark:from-blue-900 dark:via-blue-800 dark:to-blue-700">
                            <tr>
                                <th class="px-2 py-2 rounded-tl-2xl">PL</th>
                                <th class="px-2 py-2">EQUIPES</th>
                                <th class="px-2 py-2">MJ</th>
                                <th class="px-2 py-2">MG</th>
                                <th class="px-2 py-2">MP</th>
                                <th class="px-2 py-2">MN</th>
                                <th class="px-2 py-2">BP</th>
                                <th class="px-2 py-2">BC</th>
                                <th class="px-2 py-2">GD</th>
                                <th class="px-2 py-2">PTS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classement as $index => $item)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-blue-900 transition cursor-pointer" onclick="window.location='{{ route('admin.equipes.show', $item->equipe->id) }}'">
                                    <td class="px-2 py-2 font-bold">{{ $index+1 }}</td>
                                    <td class="px-2 py-2 font-semibold text-blue-700 dark:text-blue-200 flex items-center gap-2">
                                        <x-team-logo :team="$item->equipe" :size="28" />
                                        <span>{{ $item->equipe->nom ?? '-' }}</span>
                                    </td>
                                    <td class="px-2 py-2">{{ $item->mj }}</td>
                                    <td class="px-2 py-2">{{ $item->mg }}</td>
                                    <td class="px-2 py-2">{{ $item->mp }}</td>
                                    <td class="px-2 py-2">{{ $item->mn }}</td>
                                    <td class="px-2 py-2">{{ $item->bp }}</td>
                                    <td class="px-2 py-2">{{ $item->bc }}</td>
                                    <td class="px-2 py-2">{{ $item->gd }}</td>
                                    <td class="px-2 py-2 font-bold">{{ $item->points }}</td>
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
