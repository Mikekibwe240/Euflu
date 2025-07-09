@extends('layouts.admin')

@section('title', "Modifier l'Équipe")

@section('header')
    Modifier l'Équipe (Saison : {{ $saison?->nom ?? 'Aucune' }})
@endsection

@section('content')
<div class="max-w-lg mx-auto bg-bl-card border border-bl-border rounded-xl shadow-lg p-8 mt-8">
    <h2 class="text-2xl font-extrabold mb-6 text-white tracking-wide">Modifier l'équipe</h2>
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif
    <form action="{{ route('admin.equipes.update', $equipe) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-white font-semibold mb-1">Nom de l'équipe</label>
            <input type="text" name="nom" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required value="{{ old('nom', $equipe->nom) }}">
            @error('nom')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Pool</label>
            <select name="pool_id" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition">
                <option value="">Aucun (équipe libre)</option>
                @foreach($pools as $pool)
                    <option value="{{ $pool->id }}" @if(old('pool_id', $equipe->pool_id) == $pool->id) selected @endif>{{ $pool->nom }}</option>
                @endforeach
            </select>
            @error('pool_id')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Coach</label>
            <input type="text" name="coach" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required value="{{ old('coach', $equipe->coach) }}">
            @error('coach')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Logo (optionnel)</label>
            <input type="file" name="logo" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition">
            @if($equipe->logo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $equipe->logo) }}" alt="Logo actuel" class="h-12 w-12 rounded-full object-cover border border-bl-border bg-bl-dark" onerror="this.style.display='none'">
                </div>
            @endif
            @error('logo')<div class="text-red-400 text-sm mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="flex items-center gap-4 mt-6">
            <button type="submit" class="bg-bl-accent hover:bg-bl-dark text-white font-bold px-6 py-2 rounded shadow border border-bl-accent transition">Enregistrer</button>
            <a href="{{ route('admin.equipes.index') }}" class="text-gray-400 hover:text-bl-accent underline transition">Annuler</a>
        </div>
    </form>
</div>
@endsection
