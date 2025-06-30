@extends('layouts.admin')
@section('title', 'Classement des buteurs')
@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8 text-center text-yellow-600 dark:text-yellow-300">Classement des buteurs (Admin)</h1>
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full bg-white dark:bg-gray-900 text-sm">
            <thead class="bg-yellow-100 dark:bg-yellow-900">
                <tr>
                    <th class="px-2 py-2">PL</th>
                    <th class="px-2 py-2 text-left">Joueur</th>
                    <th class="px-2 py-2">Équipe</th>
                    <th class="px-2 py-2">Buts</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buteurs as $i => $joueur)
                <tr class="{{ $i < 3 ? 'bg-yellow-50 dark:bg-yellow-900/20' : '' }} cursor-pointer hover:bg-yellow-200 dark:hover:bg-yellow-800" onclick="window.location='{{ route('admin.joueurs.show', $joueur->id) }}'">
                    <td class="text-center font-bold">{{ $i+1 }}</td>
                    <td class="font-semibold text-gray-800 dark:text-gray-100">{{ $joueur->nom }} {{ $joueur->prenom }}</td>
                    <td class="text-blue-800 dark:text-blue-200">{{ $joueur->equipe->nom ?? '-' }}</td>
                    <td class="text-center font-bold text-yellow-600 dark:text-yellow-300">{{ $joueur->stats?->buts ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
