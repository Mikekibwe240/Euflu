@extends('layouts.admin')

@section('title', 'Gestion des Saisons')

@section('header')
    Gestion des Saisons
@endsection

@section('content')
<button onclick="window.history.back()" class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 transition">← Retour</button>
<div class="mb-6">
    <a href="{{ route('admin.saisons.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nouvelle saison</a>
</div>
<table class="min-w-full bg-white dark:bg-gray-800 rounded shadow table-fixed">
    <thead>
        <tr>
            <th class="px-4 py-2 w-40 text-center">Nom</th>
            <th class="px-4 py-2 w-32 text-center">Début</th>
            <th class="px-4 py-2 w-32 text-center">Fin</th>
            <th class="px-4 py-2 w-20 text-center">Active</th>
            <th class="px-4 py-2 w-32 text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($saisons as $saison)
        <tr class="border-b border-gray-200 dark:border-gray-700 text-center align-middle">
            <td class="px-4 py-2 font-semibold">{{ $saison->nom }}</td>
            <td class="px-4 py-2">{{ $saison->date_debut }}</td>
            <td class="px-4 py-2">{{ $saison->date_fin }}</td>
            <td class="px-4 py-2">
                @if($saison->active)
                    <span class="text-green-600 font-bold">Oui</span>
                @else
                    <span class="text-gray-500">Non</span>
                @endif
            </td>
            <td class="px-4 py-2">
                @if(!$saison->active)
                <form action="{{ route('admin.saisons.activate', $saison) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700">Activer</button>
                </form>
                @else
                <form action="{{ route('admin.saisons.deactivate', $saison) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-yellow-600 text-white px-2 py-1 rounded hover:bg-yellow-700">Désactiver</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
