@extends('layouts.admin')

@section('title', 'Fiche Règlement')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-bl-card rounded-2xl shadow-xl p-8 border border-bl-border">
        <div class="mb-4 flex items-center gap-4">
            <span class="inline-block bg-bl-accent text-white rounded-full px-4 py-1 font-bold text-lg shadow">N° {{ $reglement->id }}</span>
            <h1 class="text-3xl font-extrabold text-white">{{ $reglement->titre }}</h1>
        </div>
        <div class="mb-2 text-gray-400 text-sm flex flex-wrap gap-2 items-center">
            <span class="bg-bl-card border border-bl-border text-white px-2 py-1 rounded text-xs font-semibold">Saison : {{ $reglement->saison->nom ?? $reglement->saison->annee ?? '-' }}</span>
            <span class="bg-bl-card border border-bl-border text-gray-200 px-2 py-1 rounded text-xs">Auteur : {{ $reglement->user->name ?? '-' }}</span>
            <span class="bg-bl-card border border-bl-border text-green-400 px-2 py-1 rounded text-xs">Publié le : {{ $reglement->created_at->format('d/m/Y') }}</span>
            @if($reglement->updatedBy)
                <span class="bg-bl-card border border-bl-border text-yellow-400 px-2 py-1 rounded text-xs">Modifié par : {{ $reglement->updatedBy->name }}</span>
            @endif
        </div>
        <hr class="my-4 border-bl-border">
        <div class="prose dark:prose-invert max-w-none text-lg leading-relaxed text-white">
            {!! nl2br(e($reglement->contenu)) !!}
        </div>
        <div class="mt-6 flex gap-3 flex-wrap">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-4 py-2 rounded-lg shadow border border-yellow-500 transition"><i class="fas fa-arrow-left"></i> Retour</a>
            <a href="/admin/reglements/{{ $reglement->id }}/edit" class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-4 py-2 rounded-lg shadow border border-yellow-500 transition"><i class="fas fa-edit"></i> Modifier</a>
        </div>
    </div>
</div>
@endsection
