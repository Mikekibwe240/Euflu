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
            <label for="images" class="block font-semibold">Images (optionnel, plusieurs possibles)</label>
            <input type="file" name="images[]" id="images" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" accept="image/*" multiple onchange="previewImages(event)">
            @error('images')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            <div id="images-preview" class="flex flex-wrap gap-2 mt-2"></div>
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
    function previewImages(event) {
        const files = Array.from(event.target.files);
        const preview = document.getElementById('images-preview');
        preview.innerHTML = '';
        files.forEach((file, idx) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = e => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative inline-block';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'h-20 rounded shadow border border-gray-300';
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.innerHTML = '&times;';
                    btn.className = 'absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow hover:bg-red-800';
                    btn.onclick = function() {
                        removeImage(idx, event.target);
                    };
                    wrapper.appendChild(img);
                    wrapper.appendChild(btn);
                    preview.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            }
        });
    }
    function removeImage(idx, input) {
        const dt = new DataTransfer();
        const files = Array.from(input.files);
        files.splice(idx, 1);
        files.forEach(f => dt.items.add(f));
        input.files = dt.files;
        previewImages({target: input});
    }
    </script>
</div>
@endsection
