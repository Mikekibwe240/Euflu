@extends('layouts.admin')

@section('title', "Modifier l'Équipe")

@section('header')
    Modifier l'Équipe (Saison : {{ $saison?->nom ?? 'Aucune' }})
@endsection

@section('content')
<div class="max-w-lg mx-auto bg-white dark:bg-gray-800 rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Modifier l'équipe</h2>
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif
    <form action="{{ route('admin.equipes.update', $equipe) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Nom de l'équipe</label>
            <input type="text" name="nom" class="w-full mt-1 p-2 border rounded bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white" required value="{{ old('nom', $equipe->nom) }}">
            @error('nom')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Pool</label>
            <select name="pool_id" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" required>
                <option value="">Sélectionner un pool</option>
                @foreach($pools as $pool)
                    <option value="{{ $pool->id }}" @if(old('pool_id', $equipe->pool_id) == $pool->id) selected @endif>{{ $pool->nom }}</option>
                @endforeach
            </select>
            @error('pool_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Coach</label>
            <input type="text" name="coach" class="w-full mt-1 p-2 border rounded bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white" required value="{{ old('coach', $equipe->coach) }}">
            @error('coach')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-200">Logo (optionnel)</label>
            <input type="file" name="logo" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
            @if($equipe->logo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $equipe->logo) }}" alt="Logo actuel" class="h-12 w-12 rounded-full object-cover border border-gray-200 dark:border-gray-700 bg-white" onerror="this.style.display='none'">
                </div>
            @endif
            @error('logo')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Enregistrer</button>
        <a href="{{ route('admin.equipes.index') }}" class="ml-2 text-gray-600 dark:text-gray-300 hover:underline">Annuler</a>
    </form>
</div>
@endsection
