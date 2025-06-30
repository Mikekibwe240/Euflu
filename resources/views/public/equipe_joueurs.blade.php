@extends('layouts.public')

@section('title', 'Joueurs de l\'équipe ' . $equipe->nom)

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8 text-center text-blue-700 dark:text-blue-300">Joueurs de l'équipe {{ $equipe->nom }}</h1>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
        <div class="text-gray-700 dark:text-gray-200 text-lg font-semibold">
            @if(isset($position))
                Position au classement : <span class="text-blue-700 dark:text-blue-300 font-bold">{{ $position }}</span>
            @else
                <span class="text-gray-400">Classement indisponible</span>
            @endif
        </div>
    </div>
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
        @if($equipe->joueurs->isEmpty())
            <p class="text-gray-500">Aucun joueur enregistré pour cette équipe.</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow table-fixed">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="py-2 px-4 text-center">#</th>
                        <th class="py-2 px-4 text-center">Photo</th>
                        <th class="py-2 px-4 text-center">Nom</th>
                        <th class="py-2 px-4 text-center">Prénom</th>
                        <th class="py-2 px-4 text-center">Poste</th>
                        <th class="py-2 px-4 text-center">Date de naissance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipe->joueurs as $index => $joueur)
                    <tr class="border-b border-gray-200 dark:border-gray-700 text-center align-middle hover:bg-blue-50 dark:hover:bg-blue-900 transition cursor-pointer" onclick="window.location='{{ route('public.joueurs.show', $joueur->id) }}'">
                        <td class="py-2 px-4 font-semibold text-gray-800 dark:text-gray-100">{{ $index+1 }}</td>
                        <td class="py-2 px-4">
                            @if($joueur->photo)
                                <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo {{ $joueur->nom }}" class="h-10 w-10 rounded-full object-cover border border-gray-200 dark:border-gray-700 bg-white mx-auto" onerror="this.style.display='none'">
                            @else
                                <span class="flex h-10 w-10 rounded-full bg-blue-100 text-blue-700 font-bold items-center justify-center">{{ strtoupper(substr($joueur->nom,0,1)) }}</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 text-gray-800 dark:text-gray-100">{{ $joueur->nom }}</td>
                        <td class="py-2 px-4 text-gray-800 dark:text-gray-100">{{ $joueur->prenom }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200">{{ $joueur->poste }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200">{{ $joueur->date_naissance }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    <div class="mt-6 text-center">
        <a href="{{ route('public.equipes.show', $equipe->id) }}" class="text-blue-600 hover:underline">&larr; Retour à la fiche équipe</a>
    </div>
</div>
@endsection
