@extends('layouts.admin')

@section('title', "Modifier le Joueur")

@section('header')
    Modifier le Joueur (Saison : {{ $saison?->nom ?? 'Aucune' }})
@endsection

@section('content')
<div class="max-w-lg mx-auto bg-white dark:bg-gray-800 rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Modifier le joueur</h2>
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif
    <form action="{{ route('admin.joueurs.update', $joueur) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Nom</label>
            <input type="text" name="nom" class="w-full mt-1 p-2 border rounded bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white" required value="{{ old('nom', $joueur->nom) }}">
            @error('nom')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Prénom</label>
            <input type="text" name="prenom" class="w-full mt-1 p-2 border rounded bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white" required value="{{ old('prenom', $joueur->prenom) }}">
            @error('prenom')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Date de naissance</label>
            <input type="date" name="date_naissance" class="w-full mt-1 p-2 border rounded bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white" required value="{{ old('date_naissance', $joueur->date_naissance) }}">
            @error('date_naissance')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Poste</label>
            <input type="text" name="poste" class="w-full mt-1 p-2 border rounded bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white" required value="{{ old('poste', $joueur->poste) }}">
            @error('poste')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Équipe</label>
            <select name="equipe_id" class="w-full mt-1 p-2 border rounded bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">Joueur libre (sans équipe)</option>
                @foreach($equipes as $equipe)
                    <option value="{{ $equipe->id }}" @if(old('equipe_id', $joueur->equipe_id) == $equipe->id) selected @endif>{{ $equipe->nom }}</option>
                @endforeach
            </select>
            @error('equipe_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Photo (optionnelle)</label>
            <input type="file" name="photo" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
            @if($joueur->photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo actuelle" class="h-12 w-12 rounded-full object-cover border border-gray-200 dark:border-gray-700 bg-white" onerror="this.style.display='none'">
                </div>
            @endif
            @error('photo')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Numéro de licence</label>
            <input type="text" name="numero_licence" class="w-full mt-1 p-2 border rounded bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white" value="{{ old('numero_licence', $joueur->numero_licence) }}">
            @error('numero_licence')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Numéro (dossard)</label>
            <input type="text" name="numero_dossard" class="w-full mt-1 p-2 border rounded bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white" value="{{ old('numero_dossard', $joueur->numero_dossard) }}">
            @error('numero_dossard')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Nationalité</label>
            <input type="text" name="nationalite" class="w-full mt-1 p-2 border rounded bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white" value="{{ old('nationalite', $joueur->nationalite) }}">
            @error('nationalite')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Enregistrer</button>
        <a href="{{ route('admin.joueurs.index') }}" class="ml-2 text-gray-600 dark:text-gray-300 hover:underline">Annuler</a>
    </form>
</div>
@endsection