@extends('layouts.public')
@section('title', 'Matchs EUFLU')
@section('content')
<div class="max-w-6xl mx-auto mt-10 mb-8 px-2 sm:px-4 md:px-6 lg:px-0">
    @php
        $journeeActive = request()->filled('journee') && request('journee') !== '';
    @endphp
    @if($journeeActive)
        <div class="text-2xl md:text-4xl font-extrabold text-white uppercase tracking-wider mb-2">
            JOURNÉE <span class="text-[#6fcf97]">{{ request('journee') }}</span>
        </div>
    @endif
    <div class="text-sm md:text-base text-gray-400 font-semibold uppercase mb-4 md:mb-8">
        SAISON {{ $saisons->firstWhere('id', request('saison_id', $saison?->id))?->nom ?? ($saison?->nom ?? ($saisons->first()?->nom ?? '')) }}
    </div>
    <div class="flex flex-wrap md:flex-row md:items-end md:justify-between mb-6 md:mb-8 gap-2 md:gap-4">
        <form method="GET" action="" class="flex flex-wrap items-center gap-2 md:gap-4 px-2 md:px-4 py-2 md:py-3 rounded-lg bg-[#181d1f] border border-[#31363a] shadow-md w-full md:w-auto">
            <select name="journee" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] font-semibold focus:ring-2 focus:ring-[#6fcf97]" style="background-color: #181d1f !important;">
                <option value="">Toutes les journées</option>
                @foreach(($allJournees ?? $rencontres->pluck('journee')->unique()->sort()) as $j)
                    <option value="{{ $j }}" @if(request('journee', $currentJournee ?? null) == $j) selected @endif style="background-color: #181d1f; color: #6fcf97;">Journée {{ $j }}</option>
                @endforeach
            </select>
            <select name="saison_id" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] font-semibold focus:ring-2 focus:ring-[#6fcf97]" style="background-color: #181d1f !important;">
                <option value="">Toutes les saisons</option>
                @foreach($saisons as $s)
                    <option value="{{ $s->id }}" @if(request('saison_id', $saison?->id) == $s->id) selected @endif style="background-color: #181d1f; color: #6fcf97;">{{ $s->nom }}</option>
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
    <div class="space-y-3 md:space-y-4">
        <div class="hidden md:grid grid-cols-8 gap-2 md:gap-4 px-2 md:px-6 py-2 text-[#6fcf97] font-bold uppercase text-xs tracking-wider">
            <div class="text-center">Date</div>
            <div class="text-center">Equipe 1</div>
            <div></div>
            <div class="text-center">Equipe 2</div>
            <div class="text-center">Heure</div>
            <div class="text-center">Score</div>
            <div class="text-center">MVP</div>
            <div class="text-center">Pool</div>
        </div>
        @foreach($rencontres as $match)
        <a href="{{ url('/matchs/' . $match->id) }}" class="block group">
            <div class="grid grid-cols-1 md:grid-cols-8 items-center bg-[#181d1f] rounded-lg shadow px-2 md:px-6 py-3 md:py-4 border-l-4 border-[#6fcf97] gap-2 md:gap-4 transition duration-200 group-hover:bg-[#23272a] group-hover:shadow-lg group-hover:border-[#e2001a] cursor-pointer overflow-x-auto md:overflow-x-visible min-w-0">
                <div class="text-gray-400 text-xs font-bold uppercase md:col-span-1 col-span-full mb-2 md:mb-0 text-center">
                    @php
                        $date = \Carbon\Carbon::parse($match->date)->startOfDay();
                        $today = \Carbon\Carbon::now()->startOfDay();
                        $diff = $date->diffInDays($today, false);
                        if ($diff === 0) {
                            $relative = "Aujourd'hui";
                        } elseif ($diff === 1) {
                            $relative = 'Hier';
                        } elseif ($diff === 2) {
                            $relative = 'Avant-hier';
                        } elseif ($diff === -1) {
                            $relative = 'Demain';
                        } elseif ($diff === -2) {
                            $relative = 'Après-demain';
                        } elseif ($diff < 0) {
                            $relative = 'Dans ' . abs($diff) . ' jours';
                        } else {
                            $relative = 'Il y a ' . $diff . ' jours';
                        }
                    @endphp
                    {{ $relative }}
                    <span class="block text-[10px] text-gray-500 font-normal">{{ \Carbon\Carbon::parse($match->date)->locale('fr')->translatedFormat('l d F') }}</span>
                </div>
                <div class="flex items-center gap-2 min-w-0 justify-center">
                    <x-team-logo :team="$match->equipe1" :size="28" />
                    <span class="font-extrabold text-white text-base md:text-lg truncate">{{ $match->equipe1->nom }}</span>
                </div>
                <div class="text-center font-bold text-[#e2001a] text-lg md:text-xl">-</div>
                <div class="flex items-center gap-2 min-w-0 justify-center">
                    <x-team-logo :team="$match->equipe2" :size="28" />
                    <span class="font-extrabold text-white text-base md:text-lg truncate">{{ $match->equipe2->nom }}</span>
                </div>
                <div class="text-xs md:text-base text-gray-400 text-center">
                    {{ $match->heure ? \Carbon\Carbon::parse($match->heure)->format('H:i') : '-' }}
                </div>
                <div class="text-xs md:text-base text-white text-center">{{ $match->score_equipe1 !== null && $match->score_equipe2 !== null ? $match->score_equipe1 . ' - ' . $match->score_equipe2 : '-' }}</div>
                <div class="text-xs md:text-base text-[#6fcf97] text-center">
                    @if(is_object($match->mvp))
                        {{ $match->mvp->nom }} {{ $match->mvp->prenom }}
                    @elseif(is_array($match->mvp))
                        {{ $match->mvp['nom'] ?? '' }} {{ $match->mvp['prenom'] ?? '' }}
                    @elseif($match->mvp)
                        {{ $match->mvp }}
                    @else
                        -
                    @endif
                </div>
                <div class="text-xs md:text-base text-gray-400 text-center">{{ $match->pool ? ($match->pool->nom ?? '-') : ($match->type === 'amical' ? 'Amical' : '-') }}</div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="flex justify-center mt-4 gap-4">
        @if(isset($prevJournee) && $prevJournee)
            <a href="?journee={{ $prevJournee }}&saison_id={{ request('saison_id', $saisons->first()?->id) }}" class="px-8 py-3 bg-[#23272a] border-2 border-[#6fcf97] text-white font-bold rounded hover:bg-[#6fcf97] hover:text-[#23272a] transition">&larr; Journée {{ $prevJournee }}</a>
        @endif
        @if(isset($nextJournee) && $nextJournee)
            <a href="?journee={{ $nextJournee }}&saison_id={{ request('saison_id', $saisons->first()?->id) }}" class="px-8 py-3 bg-[#23272a] border-2 border-[#6fcf97] text-white font-bold rounded hover:bg-[#6fcf97] hover:text-[#23272a] transition">Journée {{ $nextJournee }} &rarr;</a>
        @endif
    </div>
</div>
@endsection
