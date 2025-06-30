@extends('layouts.public')

@section('title', 'Équipes par poule')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8 text-center text-blue-700 dark:text-blue-300">Liste des équipes par poule</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($poules as $poule)
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-blue-800 dark:text-blue-200 mb-4">Poule {{ $poule->nom }}</h2>
                @if($poule->equipes->isEmpty())
                    <p class="text-gray-500">Aucune équipe dans cette poule.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($poule->equipes as $equipe)
                            <li class="py-3 flex items-center justify-between">
                                <span class="font-medium text-lg text-gray-800 dark:text-gray-100">{{ $equipe->nom }}</span>
                                <a href="{{ route('public.equipes.show', $equipe->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded shadow hover:bg-blue-600 transition">Voir</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
