@extends('layouts.admin')

@section('title', 'Fiche Saison')

@section('header')
    Saison : {{ $saison->nom }}
@endsection

@section('content')
<a href="{{ route('admin.saisons.index') }}" class="mb-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">← Retour à la liste</a>
<div class="bg-bl-card rounded shadow p-6 max-w-xl mx-auto border border-bl-border">
    <h2 class="text-2xl font-bold mb-4 text-white">Informations sur la saison</h2>
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif
    <div class="mb-2"><span class="font-semibold text-gray-200">Nom :</span> <span class="text-white">{{ $saison->nom }}</span></div>
    <div class="mb-2"><span class="font-semibold text-gray-200">Début :</span> <span class="text-white">{{ $saison->date_debut }}</span></div>
    <div class="mb-2"><span class="font-semibold text-gray-200">Fin :</span> <span class="text-white">{{ $saison->date_fin }}</span></div>
    <div class="mb-4"><span class="font-semibold text-gray-200">Active :</span> @if($saison->active)<span class="text-green-400 font-bold">Oui</span>@else<span class="text-gray-400">Non</span>@endif</div>
    <div class="flex flex-wrap gap-2 mt-6">
        @if(!$saison->active)
        <form action="{{ route('admin.saisons.activate', $saison) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded-lg shadow hover:bg-green-800 border border-green-700 transition">Activer</button>
        </form>
        @else
        <form action="{{ route('admin.saisons.deactivate', $saison) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-700 border border-yellow-600 transition">Désactiver</button>
        </form>
        @endif
        <a href="{{ route('admin.saisons.edit', $saison) }}" class="bg-green-700 text-white px-4 py-2 rounded-lg shadow hover:bg-green-800 border border-green-700 transition">Modifier</a>
        <form action="{{ route('admin.saisons.destroy', $saison) }}" method="POST" onsubmit="return confirm('Supprimer cette saison ? Cette action est irréversible.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-800">Supprimer</button>
        </form>
    </div>
</div>
@endsection
