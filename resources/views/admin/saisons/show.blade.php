@extends('layouts.admin')

@section('title', 'Fiche Saison')

@section('header')
    Saison : {{ $saison->nom }}
@endsection

@section('content')
<a href="{{ route('admin.saisons.index') }}" class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 transition">← Retour à la liste</a>
<div class="bg-white dark:bg-gray-800 rounded shadow p-6 max-w-xl mx-auto">
    <h2 class="text-2xl font-bold mb-4 text-blue-700 dark:text-blue-300">Informations sur la saison</h2>
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif
    <div class="mb-2"><span class="font-semibold">Nom :</span> {{ $saison->nom }}</div>
    <div class="mb-2"><span class="font-semibold">Début :</span> {{ $saison->date_debut }}</div>
    <div class="mb-2"><span class="font-semibold">Fin :</span> {{ $saison->date_fin }}</div>
    <div class="mb-4"><span class="font-semibold">Active :</span> @if($saison->active)<span class="text-green-600 font-bold">Oui</span>@else<span class="text-gray-500">Non</span>@endif</div>
    <div class="flex flex-wrap gap-2 mt-6">
        @if(!$saison->active)
        <form action="{{ route('admin.saisons.activate', $saison) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Activer</button>
        </form>
        @else
        <form action="{{ route('admin.saisons.deactivate', $saison) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Désactiver</button>
        </form>
        @endif
        <a href="{{ route('admin.saisons.edit', $saison) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Modifier</a>
        <form action="{{ route('admin.saisons.destroy', $saison) }}" method="POST" onsubmit="return confirm('Supprimer cette saison ? Cette action est irréversible.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-800">Supprimer</button>
        </form>
    </div>
</div>
@endsection
