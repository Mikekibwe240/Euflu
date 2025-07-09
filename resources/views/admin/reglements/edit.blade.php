@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Modifier le règlement</h2>
    @if ($errors->any())
        <div class="bg-red-100 text-white p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.reglements.update', $reglement) }}" method="POST" class="space-y-4 bg-bl-card border border-bl-border p-6 rounded-xl shadow-lg text-bl-accent" autocomplete="off">
        @csrf
        @method('PUT')
        <div>
            <label for="titre" class="block font-semibold mb-1 text-white">Titre</label>
            <input type="text" name="titre" id="titre" class="form-input w-full bg-bl-dark border-bl-border rounded-lg text-white" value="{{ old('titre', $reglement->titre) }}" required>
            @error('titre')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="contenu" class="block font-semibold mb-1 text-white">Contenu</label>
            <textarea name="contenu" id="contenu" class="form-input w-full bg-bl-dark border-bl-border rounded-lg text-white" rows="6" required>{{ old('contenu', $reglement->contenu) }}</textarea>
            @error('contenu')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="flex gap-4 items-center mt-6">
            <button type="submit" class="bg-bl-accent hover:bg-bl-accent/90 text-white font-semibold px-6 py-2 rounded-lg shadow transition">Enregistrer</button>
            <a href="{{ route('admin.reglements.index') }}" class="ml-4 text-bl-accent hover:underline">Annuler</a>
        </div>
    </form>
</div>
@endsection
