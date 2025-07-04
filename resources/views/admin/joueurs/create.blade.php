@extends('layouts.admin')

@section('title', 'Ajouter un Joueur')

@section('header')
    Ajouter un Joueur (Saison : {{ $saison?->nom ?? 'Aucune' }})
@endsection

@section('content')
<div class="max-w-lg mx-auto bg-white dark:bg-gray-800 rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Ajouter un joueur</h2>
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif
    <form action="{{ route('admin.joueurs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Nom</label>
            <input type="text" name="nom" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" required value="{{ old('nom') }}">
            @error('nom')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Prénom</label>
            <input type="text" name="prenom" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" required value="{{ old('prenom') }}">
            @error('prenom')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Date de naissance</label>
            <input type="date" name="date_naissance" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" required value="{{ old('date_naissance') }}">
            @error('date_naissance')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Poste</label>
            <input type="text" name="poste" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" required value="{{ old('poste') }}">
            @error('poste')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Photo (optionnelle)</label>
            <input type="file" name="photo" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
            @error('photo')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Numéro de licence</label>
            <input type="text" name="numero_licence" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" value="{{ old('numero_licence') }}">
            @error('numero_licence')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Numéro (dossard)</label>
            <input type="text" name="numero_dossard" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" value="{{ old('numero_dossard') }}">
            @error('numero_dossard')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Nationalité</label>
            <input type="text" name="nationalite" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" value="{{ old('nationalite') }}">
            @error('nationalite')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter</button>
        <a href="{{ route('admin.joueurs.index') }}" class="ml-2 text-gray-600 dark:text-gray-300 hover:underline">Annuler</a>
    </form>
</div>
@endsection
