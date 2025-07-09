@extends('layouts.admin')

@section('title', "Modifier le Joueur")

@section('header')
    Modifier le Joueur (Saison : {{ $saison?->nom ?? 'Aucune' }})
@endsection

@section('content')
<div class="max-w-lg mx-auto bg-bl-card border border-bl-border rounded-xl shadow-lg p-8 mt-8">
    <h2 class="text-2xl font-extrabold mb-6 text-white tracking-wide">Modifier le joueur</h2>
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif
    <form action="{{ route('admin.joueurs.update', $joueur) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-white font-semibold mb-1">Nom</label>
            <input type="text" name="nom" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required value="{{ old('nom', $joueur->nom) }}">
            @error('nom')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Prénom</label>
            <input type="text" name="prenom" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required value="{{ old('prenom', $joueur->prenom) }}">
            @error('prenom')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Date de naissance</label>
            <input type="date" name="date_naissance" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required value="{{ old('date_naissance', $joueur->date_naissance) }}">
            @error('date_naissance')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Poste</label>
            <input type="text" name="poste" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required value="{{ old('poste', $joueur->poste) }}">
            @error('poste')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Équipe</label>
            <select name="equipe_id" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition">
                <option value="">Joueur libre (sans équipe)</option>
                @foreach($equipes as $equipe)
                    <option value="{{ $equipe->id }}" @if(old('equipe_id', $joueur->equipe_id) == $equipe->id) selected @endif>{{ $equipe->nom }}</option>
                @endforeach
            </select>
            @error('equipe_id')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Photo (optionnelle)</label>
            <input type="file" name="photo" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition">
            @if($joueur->photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo actuelle" class="h-12 w-12 rounded-full object-cover border border-bl-border bg-bl-dark" onerror="this.style.display='none'">
                </div>
            @endif
            @error('photo')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Numéro de licence</label>
            <input type="text" name="numero_licence" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" value="{{ old('numero_licence', $joueur->numero_licence) }}">
            @error('numero_licence')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Numéro (dossard)</label>
            <input type="text" name="numero_dossard" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" value="{{ old('numero_dossard', $joueur->numero_dossard) }}">
            @error('numero_dossard')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Nationalité</label>
            <input type="text" name="nationalite" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" value="{{ old('nationalite', $joueur->nationalite) }}">
            @error('nationalite')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="flex items-center gap-4 mt-6">
            <button type="submit" class="bg-bl-accent hover:bg-bl-dark text-white font-bold px-6 py-2 rounded shadow border border-bl-accent transition">Enregistrer</button>
            <a href="{{ route('admin.joueurs.index') }}" class="text-gray-400 hover:text-bl-accent underline transition">Annuler</a>
        </div>
    </form>
</div>
@endsection