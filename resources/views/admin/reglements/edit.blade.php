@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Modifier le règlement</h2>
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.reglements.update', $reglement) }}" method="POST" class="space-y-4 bg-white dark:bg-gray-800 p-6 rounded shadow text-gray-900 dark:text-gray-100">
        @csrf
        @method('PUT')
        <div>
            <label for="titre" class="block font-semibold">Titre</label>
            <input type="text" name="titre" id="titre" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" value="{{ old('titre', $reglement->titre) }}" required>
            @error('titre')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="contenu" class="block font-semibold">Contenu</label>
            <textarea name="contenu" id="contenu" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" rows="6" required>{{ old('contenu', $reglement->contenu) }}</textarea>
            @error('contenu')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="flex gap-4 items-center">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
            <a href="{{ route('admin.reglements.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
        </div>
    </form>
</div>
@endsection
