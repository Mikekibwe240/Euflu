@extends('layouts.public')
@section('title', 'Matchs Bundesliga Style')
@section('header')
<nav class="bg-[#23272a] shadow sticky top-0 z-50 border-b-4 border-[#6fcf97] bundesliga-header">
    <div class="max-w-6xl mx-auto px-4 py-0 flex items-center justify-between h-16">
        <div class="flex items-center gap-4">
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
        </div>
    </div>
</nav>
@endsection
@section('content')
<div class="max-w-6xl mx-auto mt-10 mb-8">
    <div class="text-4xl font-extrabold text-white uppercase tracking-wider mb-2">
        JOURNÉE <span class="text-[#6fcf97]">{{ request('journee', 1) }}</span>
    </div>
    <div class="text-base text-gray-400 font-semibold uppercase mb-8">
        SAISON {{ $saisons->firstWhere('id', request('saison_id'))?->nom ?? ($saisons->first()?->nom ?? '') }}
    </div>
    <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-8 gap-4">
        <form method="GET" action="" class="flex items-center gap-4 px-4 py-3 rounded-lg bg-[#181d1f] border border-[#31363a] shadow-md">
            <select name="journee" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] font-semibold focus:ring-2 focus:ring-[#6fcf97]" style="background-color: #181d1f !important;">
                <option value="">Toutes les journées</option>
                @foreach($rencontres->pluck('journee')->unique()->sort() as $j)
                    <option value="{{ $j }}" @if(request('journee') == $j) selected @endif style="background-color: #181d1f; color: #6fcf97;">Journée {{ $j }}</option>
                @endforeach
            </select>
            <select name="saison_id" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] font-semibold focus:ring-2 focus:ring-[#6fcf97]" style="background-color: #181d1f !important;">
                <option value="">Toutes les saisons</option>
                @foreach($saisons as $s)
                    <option value="{{ $s->id }}" @if(request('saison_id') == $s->id) selected @endif style="background-color: #181d1f; color: #6fcf97;">{{ $s->nom }}</option>
                @endforeach
            </select>
            <select name="equipe_id" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] font-semibold focus:ring-2 focus:ring-[#6fcf97]" style="background-color: #181d1f !important;">
                <option value="">Tous les clubs</option>
                @foreach($equipes as $c)
                    <option value="{{ $c->id }}" @if(request('equipe_id') == $c->id) selected @endif style="background-color: #181d1f; color: #6fcf97;">{{ $c->nom }}</option>
                @endforeach
            </select>
            <select name="pool_id" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] font-semibold focus:ring-2 focus:ring-[#6fcf97]" style="background-color: #181d1f !important;">
                <option value="">Tous les pools</option>
                <option value="A" @if(request('pool_id') == 'A') selected @endif style="background-color: #181d1f; color: #6fcf97;">A</option>
                <option value="B" @if(request('pool_id') == 'B') selected @endif style="background-color: #181d1f; color: #6fcf97;">B</option>
                <option value="AMICAL" @if(request('pool_id') == 'AMICAL') selected @endif style="background-color: #181d1f; color: #6fcf97;">AMICAL</option>
            </select>
            <button type="submit" class="ml-2 px-5 py-2 bg-gradient-to-r from-[#e2001a] to-[#b80016] text-white font-extrabold rounded shadow-lg hover:from-[#b80016] hover:to-[#e2001a] focus:outline-none focus:ring-2 focus:ring-[#6fcf97] transition">OK</button>
        </form>
    </div>
    <div class="space-y-4">
        <div class="hidden md:grid grid-cols-8 gap-4 px-6 py-2 text-[#6fcf97] font-bold uppercase text-xs tracking-wider">
            <div>Date</div>
            <div>Equipe 1</div>
            <div></div>
            <div>Equipe 2</div>
            <div>Heure</div>
            <div>Score</div>
            <div>MVP</div>
            <div>Pool</div>
        </div>
        @foreach($rencontres as $match)
        <a href="{{ url('/matchs/' . $match->id) }}" class="block group">
            <div class="grid grid-cols-1 md:grid-cols-8 items-center bg-[#181d1f] rounded-lg shadow px-6 py-4 border-l-4 border-[#6fcf97] gap-2 md:gap-4 transition duration-200 group-hover:bg-[#23272a] group-hover:shadow-lg group-hover:border-[#e2001a] cursor-pointer">
                <div class="text-gray-400 text-xs font-bold uppercase">
                    {{ \Carbon\Carbon::parse($match->date)->locale('fr')->translatedFormat('l d F') }}
                </div>
                <div class="flex items-center gap-2">
                    <x-team-logo :team="$match->equipe1" :size="28" />
                    <span class="font-extrabold text-white text-lg">{{ $match->equipe1->nom }}</span>
                </div>
                <span class="font-extrabold text-white text-lg text-center">VS</span>
                <div class="flex items-center gap-2">
                    <x-team-logo :team="$match->equipe2" :size="28" />
                    <span class="font-extrabold text-white text-lg">{{ $match->equipe2->nom }}</span>
                </div>
                <div class="text-white font-bold text-lg">{{ $match->heure ?? '--:--' }}</div>
                <div>
                    @if(isset($match->statut) && $match->statut === 'joue')
                        <span class="text-white font-bold">{{ $match->score ?? '-' }}</span>
                    @else
                        <span class="text-gray-500">-</span>
                    @endif
                </div>
                <div>
                    @if(isset($match->statut) && $match->statut === 'joue')
                        <span class="text-white font-bold">{{ $match->mvp?->nom ?? '-' }}</span>
                    @else
                        <span class="text-gray-500">-</span>
                    @endif
                </div>
                <div class="text-[#e2001a] font-bold text-xs uppercase">
                    @if($match->pool)
                        {{ strtoupper($match->pool->nom) }}
                    @elseif($match->type_rencontre === 'amical' || $match->type_rencontre === 'externe')
                        AMICAL
                    @else
                        -
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="flex justify-center mt-8">
        @php
            $nextJournee = $rencontres->pluck('journee')->unique()->sort()->filter(fn($j) => $j > request('journee', 1))->first();
        @endphp
        @if($nextJournee)
        <a href="?journee={{ $nextJournee }}&saison_id={{ request('saison_id', $saisons->first()?->id) }}" class="px-8 py-3 bg-[#23272a] border-2 border-[#6fcf97] text-white font-bold rounded hover:bg-[#6fcf97] hover:text-[#23272a] transition">MATCHDAY {{ $nextJournee }}</a>
        @endif
    </div>
</div>
@endsection
