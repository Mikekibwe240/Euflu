@extends('layouts.admin')

@section('title', 'Fiche Règlement')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8 border border-blue-100 dark:border-blue-800">
        <div class="mb-4 flex items-center gap-4">
            <span class="inline-block bg-blue-600 text-white rounded-full px-4 py-1 font-bold text-lg shadow">N° {{ $reglement->id }}</span>
            <h1 class="text-3xl font-extrabold text-blue-800 dark:text-blue-200">{{ $reglement->titre }}</h1>
        </div>
        <div class="mb-2 text-gray-500 dark:text-gray-400 text-sm flex flex-wrap gap-2 items-center">
            <span class="bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-200 px-2 py-1 rounded text-xs font-semibold">Saison : {{ $reglement->saison->nom ?? $reglement->saison->annee ?? '-' }}</span>
            <span class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-2 py-1 rounded text-xs">Auteur : {{ $reglement->user->name ?? '-' }}</span>
            <span class="bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-200 px-2 py-1 rounded text-xs">Publié le : {{ $reglement->created_at->format('d/m/Y') }}</span>
            @if($reglement->updatedBy)
                <span class="bg-yellow-100 dark:bg-yellow-800 text-yellow-700 dark:text-yellow-200 px-2 py-1 rounded text-xs">Modifié par : {{ $reglement->updatedBy->name }}</span>
            @endif
        </div>
        <hr class="my-4 border-gray-200 dark:border-gray-700">
        <div class="prose dark:prose-invert max-w-none text-lg leading-relaxed">
            {!! nl2br(e($reglement->contenu)) !!}
        </div>
        <div class="mt-6 flex gap-3 flex-wrap">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-blue-100 text-blue-700 font-bold px-4 py-2 rounded-lg shadow transition"><i class="fas fa-arrow-left"></i> Retour</a>
        </div>
    </div>
</div>
@endsection
