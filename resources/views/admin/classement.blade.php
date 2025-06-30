@extends('layouts.admin')

@section('title', 'Classement par poule')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8 text-center text-blue-700 dark:text-blue-300">Classement par poule (Admin)</h1>
    <div class="space-y-12">
        @foreach($poules as $poule)
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 mb-8">
                <div class="flex flex-wrap gap-4 mb-4 items-center justify-between">
                    <h2 class="text-2xl font-bold text-blue-600 dark:text-blue-300">Poule {{ $poule->nom }}</h2>
                    <div class="flex flex-wrap gap-2">
                        <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-4 py-2 rounded-xl flex flex-col items-center min-w-[90px]">
                            <span class="font-bold text-lg">{{ $poule->classement->where('qualifie', true)->count() }}</span>
                            <span class="text-xs font-semibold">Qualifiés</span>
                        </div>
                        <div class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-4 py-2 rounded-xl flex flex-col items-center min-w-[90px]">
                            <span class="font-bold text-lg">{{ $poule->classement->where('relegue', true)->count() }}</span>
                            <span class="text-xs font-semibold">Relégués</span>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-4 py-2 rounded-xl flex flex-col items-center min-w-[90px]">
                            <span class="font-bold text-lg">{{ $poule->classement->count() }}</span>
                            <span class="text-xs font-semibold">Équipes</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-semibold">
                            Journées&nbsp;: <span class="ml-1 font-bold">{{ $poule->classement->max('journee') ?? '-' }}</span>
                        </span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mb-4">
                    <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg px-4 py-2 flex flex-col items-center min-w-[120px]">
                        <span class="font-bold text-lg text-blue-700 dark:text-blue-200">Total buts</span>
                        <span class="text-xl font-bold">{{ $poule->classement->sum('bp') }}</span>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg px-4 py-2 flex flex-col items-center min-w-[120px]">
                        <span class="font-bold text-lg text-green-700 dark:text-green-200">Total matchs</span>
                        <span class="text-xl font-bold">{{ $poule->classement->sum('mj') }}</span>
                    </div>
                    <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg px-4 py-2 flex flex-col items-center min-w-[120px]">
                        <span class="font-bold text-lg text-yellow-700 dark:text-yellow-200">Ratio buts/match</span>
                        <span class="text-xl font-bold">{{ $poule->classement->sum('mj') ? number_format($poule->classement->sum('bp') / $poule->classement->sum('mj'), 2) : '-' }}</span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mb-4">
                    <a href="{{ route('admin.classement_buteurs', ['pool' => $poule->id]) }}" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 transition">Classement buteurs</a>
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
                            @foreach($poule->classement as $index => $item)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-blue-900 transition cursor-pointer" onclick="window.location='{{ route('admin.equipes.show', $item->equipe->id) }}'">
                                    <td class="px-2 py-2 font-bold">{{ $index+1 }}</td>
                                    <td class="px-2 py-2 font-semibold text-blue-700 dark:text-blue-200">{{ $item->equipe->nom ?? '-' }}</td>
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
