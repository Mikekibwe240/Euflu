@extends('layouts.public')

@section('title', 'Règlement')

@section('header')
<nav class="bg-[#23272a] shadow sticky top
    <div class="max-w-6xl mx-auto px-4 py-0 flex items-center justify-between h-16">
        <div class="flex items-center gap-4">
            <span class="bundesliga-logo">EUFLU</span>
        </div>
        <div class="bundesliga-menu hidden md:flex gap-6 font-bold uppercase text-white text-sm tracking-wider">
            <a href="/" class="px-2 py-1">Accueil</a>
            <a href="/classement" class="px-2 py-1">Classement</a>
            <a href="/matchs" class="px-2 py-1">Fixation et Résultats</a>
            <a href="/equipes" class="px-2 py-1">Equipes
            <a href="/joueurs" class="px-2 py-1">Joueurs</a>
            <a href="/buteurs" class="px-2 py-1">Buteurs</a>
            <a href="/articles" class="px-2 py-1">Actualités</a>
            <a href="/videos" class="px-2 py-1">Videos</a>
            <a href="/stats" class="px-2 py-1">Stats</a>
            <a href="/awards" class="px-2 py-1">Awards</a>
        </div>
    </div>
</nav>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="bg-[#181d1f] rounded-lg shadow-lg border border-[#31363a] p-8">
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#e2001a] mb-4 text-center uppercase tracking-wider">{{ $reglement->titre }}</h1>
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
            <div class="text-sm text-gray-400 font-semibold mb-2 md:mb-0">
                Saison : <span class="text-[#6fcf97]">{{ $reglement->saison->nom ?? $reglement->saison->annee ?? '-' }}</span>
            </div>
            <div class="text-sm text-gray-400 font-semibold">
                Auteur : <span class="text-white">{{ $reglement->user->name ?? '-' }}</span>
            </div>
            <div class="text-sm text-gray-400 font-semibold">
                Publié le : <span class="text-white">{{ $reglement->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
        <div class="prose prose-invert max-w-none text-gray-200 text-lg leading-relaxed">
            {!! nl2br(e($reglement->contenu)) !!}
        </div>
        <div class="mt-8 flex justify-center">
            <a href="{{ route('public.reglements.index') }}" class="inline-block bg-[#6fcf97] text-[#23272a] font-bold px-6 py-2 rounded-full shadow hover:bg-[#23272a] hover:text-[#6fcf97] transition-all duration-300">← Retour à la liste</a>
        </div>
    </div>
</div>
@endsection
