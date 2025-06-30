@extends('layouts.public')

@section('title', 'Recherche d\'équipe')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-center text-blue-700 dark:text-blue-300">Rechercher une équipe</h1>
    <form method="GET" action="{{ route('public.equipes.search') }}" class="flex justify-center mb-8">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Nom de l'équipe..." class="w-1/2 px-4 py-2 rounded-l border border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-r hover:bg-blue-700 transition">Rechercher</button>
    </form>
    @if(isset($equipes))
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
            @if($equipes->isEmpty())
                <p class="text-center text-gray-500">Aucune équipe trouvée.</p>
            @else
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($equipes as $equipe)
                        <li class="py-4 flex items-center justify-between">
                            <div>
                                <span class="font-semibold text-lg text-blue-800 dark:text-blue-200">{{ $equipe->nom }}</span>
                                <span class="ml-4 text-gray-500">({{ $equipe->pool->nom ?? 'Sans poule' }})</span>
                            </div>
                            <a href="{{ route('public.equipes.show', $equipe->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">Voir</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
</div>
@endsection
