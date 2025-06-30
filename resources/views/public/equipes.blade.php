@extends('layouts.public')

@section('title', 'Equipes')

@section('header')
<nav class="bg-[#23272a] shadow sticky top-0 z-50 border-b-4 border-[#6fcf97] bundesliga-header">
    <div class="max-w-6xl mx-auto px-4 py-0 flex items-center justify-between h-16">
        <div class="flex items-center gap-4">
            <img src="/storage/img_euflu/fecofa.png" alt="Logo Fecofa" class="h-10 w-10 rounded-full bg-white border-2 border-[#E2001A]" />
            <span class="bundesliga-logo">EUFLU</span>
        </div>
        <div class="bundesliga-menu hidden md:flex gap-6 font-bold uppercase text-white text-sm tracking-wider">
            <a href="/" class="px-2 py-1">Accueil</a>
            <a href="/classement" class="px-2 py-1">Classement</a>
            <a href="/matchs" class="px-2 py-1">Fixation et Résultats</a>
            <a href="/equipes" class="px-2 py-1">Equipes</a>
            <a href="/joueurs" class="px-2 py-1">Joueurs</a>
            <a href="/buteurs" class="px-2 py-1">Buteurs</a>
            <a href="/articles" class="px-2 py-1">Actualités</a>
            <a href="/videos" class="px-2 py-1">Videos</a>
            <a href="/stats" class="px-2 py-1">Stats</a>
            <a href="/awards" class="px-2 py-1">Awards</a>
            <a href="/reglements" class="px-2 py-1">Reglements</a>
        </div>
    </div>
</nav>
@endsection

@section('content')
<div class="max-w-6xl mx-auto mt-10 mb-8">
    <div class="text-4xl font-extrabold text-white uppercase tracking-wider mb-2">CLUBS</div>
    <div class="text-base text-gray-400 font-semibold uppercase mb-8">{{ $saison?->nom }}</div>
    @foreach($pools as $pool)
        <div class="mb-8">
            <div class="text-2xl font-bold text-[#e2001a] uppercase mb-4">Pool {{ $pool->nom }}</div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($pool->equipes as $equipe)
                    <a href="{{ route('equipes.show', ['equipe' => $equipe->id]) }}" class="block bg-[#23272a] rounded-lg shadow-lg p-6 hover:bg-[#181d1f] transition group border border-[#31363a]">
                        <div class="flex items-center gap-4 mb-2">
                            <x-team-logo :team="$equipe" :size="48" />
                            <span class="font-extrabold text-white text-lg group-hover:text-[#6fcf97]">{{ $equipe->nom }}</span>
                        </div>
                        <div class="text-gray-400 text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                            {{ $equipe->stade ?? 'Stade inconnu' }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection
