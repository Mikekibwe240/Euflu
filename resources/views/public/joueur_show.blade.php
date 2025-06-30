@extends('layouts.public')

@section('title', 'Détail du joueur')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mb-8 flex flex-col md:flex-row items-center gap-8">
        <div class="flex-shrink-0 flex flex-col items-center">
            @if($joueur->photo)
                <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo {{ $joueur->nom }}" class="h-32 w-32 rounded-full object-cover border-4 border-blue-200 dark:border-blue-700 mb-4">
            @else
                <div class="h-32 w-32 flex items-center justify-center rounded-full bg-blue-100 text-blue-700 font-bold text-4xl mb-4">{{ strtoupper(substr($joueur->nom,0,2)) }}</div>
            @endif
            <div class="text-xl font-semibold text-blue-800 dark:text-blue-200">{{ $joueur->nom }} {{ $joueur->prenom }}</div>
            <div class="text-gray-500 dark:text-gray-300">Équipe : {{ $joueur->equipe->nom ?? 'Sans équipe' }}</div>
            <div class="text-gray-500 dark:text-gray-300">Poste : {{ $joueur->poste ?? '-' }}</div>
            <div class="text-gray-500 dark:text-gray-300">Date de naissance : {{ $joueur->date_naissance ?? '-' }}</div>
        </div>
        <div class="flex-1 w-full">
            <h2 class="text-2xl font-semibold text-blue-700 dark:text-blue-300 mb-4">Statistiques</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gradient-to-br from-blue-100 to-blue-300 dark:from-blue-900 dark:to-blue-700 rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-blue-800 dark:text-blue-200 mb-2">{{ isset($joueur->buts) ? $joueur->buts->count() : 0 }}</div>
                    <div class="text-lg text-blue-700 dark:text-blue-300 font-semibold">Buts marqués</div>
                </div>
                <div class="bg-gradient-to-br from-green-100 to-green-300 dark:from-green-900 dark:to-green-700 rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-green-800 dark:text-green-200 mb-2">{{ isset($joueur->buts) ? $joueur->buts->pluck('rencontre_id')->unique()->count() : 0 }}</div>
                    <div class="text-lg text-green-700 dark:text-green-300 font-semibold">Matchs joués</div>
                </div>
                <div class="bg-gradient-to-br from-yellow-100 to-yellow-300 dark:from-yellow-900 dark:to-yellow-700 rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-yellow-800 dark:text-yellow-200 mb-2">
                        @php
                            $ratio = (isset($joueur->buts) && $joueur->buts->pluck('rencontre_id')->unique()->count() > 0)
                                ? round($joueur->buts->count() / $joueur->buts->pluck('rencontre_id')->unique()->count(), 2)
                                : 0;
                        @endphp
                        {{ $ratio }}
                    </div>
                    <div class="text-lg text-yellow-700 dark:text-yellow-300 font-semibold">Ratio Buts / Match</div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-between">
        <a href="{{ url()->previous() }}" class="inline-block bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 font-bold px-6 py-2 rounded-full shadow hover:bg-primary-700 dark:hover:bg-gray-300 transition-all duration-300 font-inter">← Retour</a>
    </div>
</div>
@endsection
