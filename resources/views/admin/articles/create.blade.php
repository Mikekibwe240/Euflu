@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Ajouter un article</h2>
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @php
        $saisonCourante = $saisons->firstWhere('etat', 'ouverte');
        $saisonSelected = old('saison_id', $saisonCourante?->id);
    @endphp
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white dark:bg-gray-800 p-6 rounded shadow text-gray-900 dark:text-gray-100">
        @csrf
        <div>
            <label for="titre" class="block font-semibold">Titre</label>
            <select name="titre" id="titre" class="form-select w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" required>
                <option value="">Sélectionner un titre</option>
                @foreach(['Actualités', 'Communiqué', 'Interview', 'Annonce', 'Joueur du mois'] as $titre)
                    <option value="{{ $titre }}" {{ old('titre') == $titre ? 'selected' : '' }}>{{ $titre }}</option>
                @endforeach
            </select>
            @error('titre')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="contenu" class="block font-semibold">Contenu</label>
            <textarea name="contenu" id="contenu" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" rows="6" required>{{ old('contenu') }}</textarea>
            @error('contenu')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="saison_id" class="block font-semibold">Saison</label>
            <select name="saison_id" id="saison_id" class="form-select w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" required>
                <option value="">Sélectionner une saison</option>
                @foreach($saisons as $saison)
                    <option value="{{ $saison->id }}" {{ $saisonSelected == $saison->id ? 'selected' : '' }}>{{ $saison->annee }}</option>
                @endforeach
            </select>
            @error('saison_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="published_at" class="block font-semibold">Date de publication</label>
            <input type="datetime-local" name="published_at" id="published_at" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" value="{{ old('published_at', now()->setTimezone('Africa/Kinshasa')->format('Y-m-d\TH:i')) }}">
            @error('published_at')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="video" class="block font-semibold">Vidéo (optionnel, mp4)</label>
            <input type="file" name="video" id="video" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" accept="video/mp4">
            @error('video')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="image1" class="block font-semibold">Image 1 (optionnel)</label>
            <input type="file" name="images[]" id="image1" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" accept="image/*">
            @error('images.0')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="image2" class="block font-semibold">Image 2 (optionnel)</label>
            <input type="file" name="images[]" id="image2" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" accept="image/*">
            @error('images.1')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="image3" class="block font-semibold">Image 3 (optionnel)</label>
            <input type="file" name="images[]" id="image3" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" accept="image/*">
            @error('images.2')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="flex gap-4 items-center">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Ajouter</button>
            <button type="button" onclick="apercuArticle()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Aperçu</button>
            <a href="{{ route('admin.articles.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
        </div>
    </form>
    <script>
    function apercuArticle() {
        const titre = document.getElementById('titre').value;
        const contenu = document.getElementById('contenu').value;
        const win = window.open('', '_blank');
        win.document.write('<h2>' + titre + '</h2><div>' + contenu.replace(/\n/g, '<br>') + '</div>');
    }
    </script>
</div>
@endsection
