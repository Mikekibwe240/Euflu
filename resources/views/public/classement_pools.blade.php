@extends('layouts.public')

@section('title', 'Classement par Pool')

@section('header')
<nav class="bg-[#23272a] shadow sticky top-0 z-50 border-b-4 border-[#6fcf97] bundesliga-header">
    <div class="max-w-6xl mx-auto px-4 py-0 flex items-center justify-between h-16">
        <div class="flex items-center gap-4">
            <span class="bundesliga-logo">EUFLU</span>
        </div>
        <div class="bundesliga-menu hidden md:flex gap-6 font-bold uppercase text-white text-sm tracking-wider">
            <a href="/" class="px-2 py-1">Accueil</a>
            <a href="/classement" class="px-2 py-1">Classement</a>
            <a href="/matchs" class="px-2 py-1">Fixation et Résultats</a>
            <a href="/equipes" class="px-2 py-1">Equipes</a>
            <a href="/joueurs" class="px-2 py-1">Joueurs</a>
            <a href="/buteurs" class="px-2 py-1">Buteurs</a>
            <a href="/articles" class="px-2 py-1">Actualités</a>
            <a href="/videos" class="px-2 py-1">Videos</a>
            <a href="/stats" class="px-2 py-1">Stats</a>
            <a href="/awards" class="px-2 py-1">Awards</a>
        </div>
    </div>
</nav>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8 text-center text-gray-900 dark:text-white font-inter">Classement par Pool</h1>
    @foreach($poules as $poule)
        <div class="mb-10">
            <h2 class="text-2xl font-bold mb-4 text-center uppercase tracking-widest text-gray-900 dark:text-white font-roboto">POOL {{ $poule->nom }}</h2>
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full bg-white dark:bg-gray-900 text-sm">
                    <thead class="bg-blue-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-2 py-2">PL</th>
                            <th class="px-2 py-2 text-left">EQUIPES</th>
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
                        @foreach($poule->classement as $i => $stat)
                        <tr class="{{ $i < 3 ? 'bg-yellow-50 dark:bg-yellow-900/20' : '' }}">
                            <td class="text-center font-bold">{{ $i+1 }}</td>
                            <td class="font-semibold text-gray-900 dark:text-white font-roboto">{{ $stat->equipe->nom }}</td>
                            <td class="text-center">{{ $stat->mj }}</td>
                            <td class="text-center">{{ $stat->mg }}</td>
                            <td class="text-center">{{ $stat->mp }}</td>
                            <td class="text-center">{{ $stat->mn }}</td>
                            <td class="text-center">{{ $stat->bp }}</td>
                            <td class="text-center">{{ $stat->bc }}</td>
                            <td class="text-center font-bold {{ $stat->gd > 0 ? 'text-green-600' : ($stat->gd < 0 ? 'text-red-600' : 'text-gray-700') }}">{{ $stat->gd }}</td>
                            <td class="text-center font-bold text-primary-700 dark:text-primary-300">{{ $stat->points }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection
