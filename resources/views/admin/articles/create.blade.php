@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-bl-card border border-bl-border rounded-xl shadow-lg p-8 mt-8">
    <h2 class="text-2xl font-extrabold mb-6 text-white tracking-wide">Ajouter un article</h2>
    @if ($errors->any())
        <div class="bg-red-900/80 text-white border border-red-700 p-3 mb-6 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div>
            <label for="titre" class="block font-semibold text-white mb-1">Titre</label>
            <select name="titre" id="titre" class="form-select w-full bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required>
                <option value="">Sélectionner un titre</option>
                @foreach(['Actualités', 'Communiqué', 'Interview', 'Annonce', 'Joueur du mois'] as $titre)
                    <option value="{{ $titre }}" {{ old('titre') == $titre ? 'selected' : '' }}>{{ $titre }}</option>
                @endforeach
            </select>
            @error('titre')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="contenu" class="block font-semibold text-white mb-1">Contenu</label>
            <textarea name="contenu" id="contenu" class="form-input w-full bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" rows="6" required>{{ old('contenu') }}</textarea>
            @error('contenu')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="published_at" class="block font-semibold text-white mb-1">Date de publication</label>
            <input type="datetime-local" name="published_at" id="published_at" class="form-input w-full bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" value="{{ old('published_at', now()->setTimezone('Africa/Kinshasa')->format('Y-m-d\TH:i')) }}">
            @error('published_at')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="video" class="block font-semibold text-white mb-1">Vidéo (optionnel, mp4)</label>
            <input type="file" name="video" id="video" class="form-input w-full bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" accept="video/mp4">
            @error('video')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="images" class="block font-semibold text-white mb-1">Images (optionnel, plusieurs possibles)</label>
            <input type="file" name="images[]" id="images" class="form-input w-full bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" accept="image/*" multiple onchange="previewImages(event)">
            @error('images')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            <div id="images-preview" class="flex flex-wrap gap-2 mt-2"></div>
        </div>
        <div class="flex gap-4 items-center mt-8">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2 rounded shadow border border-green-600 transition">Ajouter</button>
            <a href="{{ route('admin.articles.index') }}" class="ml-4 bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-2 rounded shadow border border-yellow-500 transition">Annuler</a>
        </div>
    </form>
    <script>
    function previewImages(event) {
        const files = event.target.files;
        const preview = document.getElementById('images-preview');
        preview.innerHTML = '';
        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'h-20 rounded shadow border border-bl-border';
                preview.appendChild(img);
            };
            reader.readAsDataURL(files[i]);
        }
    }
    </script>
</div>
@endsection
