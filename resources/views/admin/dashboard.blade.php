@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('header')
    Tableau de bord
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Saisons actives</div>
        <div class="text-3xl font-bold text-blue-700 dark:text-blue-300 mt-2">{{ $saisonsActives ?? 0 }}</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Équipes</div>
        <div class="text-3xl font-bold text-green-700 dark:text-green-300 mt-2">{{ $equipes ?? 0 }}</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Joueurs</div>
        <div class="text-3xl font-bold text-yellow-700 dark:text-yellow-300 mt-2">{{ $joueurs ?? 0 }}</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Utilisateurs</div>
        <div class="text-3xl font-bold text-purple-700 dark:text-purple-300 mt-2">{{ $users ?? 0 }}</div>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Articles publiés</div>
        <div class="text-3xl font-bold text-pink-700 dark:text-pink-300 mt-2">{{ $articles ?? 0 }}</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Matchs</div>
        <div class="text-3xl font-bold text-indigo-700 dark:text-indigo-300 mt-2">{{ $matchs ?? 0 }}</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Buts marqués</div>
        <div class="text-3xl font-bold text-red-700 dark:text-red-300 mt-2">{{ $buts ?? 0 }}</div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Cartons</div>
        <div class="text-3xl font-bold text-orange-700 dark:text-orange-300 mt-2">{{ $cartons ?? 0 }}</div>
    </div>
</div>
<div class="mt-8">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Bienvenue sur le tableau de bord administrateur !</h2>
    <p class="text-gray-600 dark:text-gray-300 mb-8">Utilisez le menu à gauche pour gérer les saisons, équipes, joueurs, matchs, articles et règlements.</p>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
        <a href="{{ route('admin.joueurs.index') }}" class="bg-blue-600 text-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-blue-700 transition">
            <span class="text-3xl mb-2">👤</span>
            <span class="font-bold text-lg">Gérer les joueurs</span>
        </a>
        <a href="{{ route('admin.equipes.index') }}" class="bg-green-600 text-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-green-700 transition">
            <span class="text-3xl mb-2">⚽</span>
            <span class="font-bold text-lg">Gérer les équipes</span>
        </a>
        <a href="{{ route('admin.rencontres.index') }}" class="bg-indigo-600 text-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-indigo-700 transition">
            <span class="text-3xl mb-2">📅</span>
            <span class="font-bold text-lg">Voir les matchs</span>
        </a>
        <a href="{{ route('admin.articles.index') }}" class="bg-pink-600 text-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-pink-700 transition">
            <span class="text-3xl mb-2">📰</span>
            <span class="font-bold text-lg">Articles</span>
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        @foreach($poules as $poule)
            <div class="bg-gray-50 dark:bg-gray-900 rounded-xl shadow p-6 flex flex-col items-center gap-4">
                {{-- <div class="text-lg font-bold text-blue-700 dark:text-blue-300 mb-2">Poule {{ $poule->nom }}</div> --}}
                {{-- <a href="{{ route('admin.classement', ['poule' => $poule->id]) }}" class="w-full bg-blue-600 text-white rounded-lg shadow px-4 py-2 text-center font-semibold hover:bg-blue-700 transition">Classement équipes</a> --}}
                {{-- <a href="{{ route('admin.classement_buteurs', ['pool' => $poule->id]) }}" class="w-full bg-yellow-500 text-white rounded-lg shadow px-4 py-2 text-center font-semibold hover:bg-yellow-600 transition">Classement buteurs</a> --}}
            </div>
        @endforeach
    </div>
</div>
@include('admin.dashboard_graphs')
@endsection
