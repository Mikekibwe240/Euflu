@extends('layouts.admin')

@section('title', 'Nouvelle Saison')

@section('header')
    Nouvelle Saison
@endsection

@section('content')
<div class="max-w-lg mx-auto bg-white dark:bg-gray-800 rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Créer une nouvelle saison</h2>
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.saisons.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nom" class="block text-gray-900 dark:text-gray-100 font-semibold">Nom de la saison</label>
            <input type="text" name="nom" id="nom" class="w-full mt-1 p-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" value="{{ old('nom') }}" required>
        </div>
        <div class="mb-4">
            <label for="date_debut" class="block text-gray-900 dark:text-gray-100 font-semibold">Date de début</label>
            <input type="date" name="date_debut" id="date_debut" class="w-full mt-1 p-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" value="{{ old('date_debut') }}" required>
        </div>
        <div class="mb-4">
            <label for="date_fin" class="block text-gray-900 dark:text-gray-100 font-semibold">Date de fin</label>
            <input type="date" name="date_fin" id="date_fin" class="w-full mt-1 p-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" value="{{ old('date_fin') }}" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Créer</button>
        <a href="{{ route('admin.saisons.index') }}" class="ml-2 text-gray-600 dark:text-gray-300 hover:underline">Annuler</a>
    </form>
</div>
@endsection
