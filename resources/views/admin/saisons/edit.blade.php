@extends('layouts.admin')

@section('title', 'Modifier Saison')

@section('header')
    Modifier Saison
@endsection

@section('content')
<div class="max-w-lg mx-auto bg-bl-card border border-bl-border rounded-xl shadow-lg p-8 mt-8">
    <h2 class="text-2xl font-extrabold mb-6 text-bl-accent tracking-wide">Modifier la saison</h2>
    @if ($errors->any())
        <div class="bg-red-900/80 text-white border border-red-700 p-3 mb-6 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.saisons.update', $saison) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="nom" class="block text-white font-semibold mb-1">Nom de la saison</label>
            <input type="text" name="nom" id="nom" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" value="{{ old('nom', $saison->nom) }}" required>
        </div>
        <div>
            <label for="date_debut" class="block text-white font-semibold mb-1">Date de début</label>
            <input type="date" name="date_debut" id="date_debut" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" value="{{ old('date_debut', $saison->date_debut) }}" required>
        </div>
        <div>
            <label for="date_fin" class="block text-white font-semibold mb-1">Date de fin</label>
            <input type="date" name="date_fin" id="date_fin" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" value="{{ old('date_fin', $saison->date_fin) }}" required>
        </div>
        <div class="flex items-center gap-4 mt-6">
            <button type="submit" class="bg-bl-accent hover:bg-bl-dark text-white font-bold px-6 py-2 rounded shadow border border-bl-accent transition">Enregistrer</button>
            <a href="{{ route('admin.saisons.index') }}" class="text-gray-400 hover:text-bl-accent underline transition">Annuler</a>
        </div>
    </form>
</div>
@endsection
