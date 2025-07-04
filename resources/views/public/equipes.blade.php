@extends('layouts.public')

@section('title', 'Equipes')

@section('content')
<div class="max-w-6xl mx-auto mt-10 mb-8">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-8 gap-4">
        <div>
            <div class="text-4xl font-extrabold text-white uppercase tracking-wider mb-2">CLUBS</div>
            <div class="text-base text-gray-400 font-semibold uppercase">{{ $saison?->nom }}</div>
        </div>
        <form method="GET" action="" class="flex items-center gap-4 px-4 py-3 rounded-lg bg-[#181d1f] border border-[#31363a] shadow-md">
            <label for="saison_id" class="text-gray-200 font-bold uppercase tracking-wide mr-2">Saison</label>
            @if($saisons->isEmpty())
                <span class="text-gray-400 italic">Aucune saison disponible</span>
            @else
                <select name="saison_id" id="saison_id" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] focus:outline-none focus:ring-2 focus:ring-[#e2001a] font-semibold shadow-sm transition placeholder-gray-400">
                    @foreach($saisons as $s)
                        <option value="{{ $s->id }}" @if(request('saison_id', $saison?->id) == $s->id) selected @endif style="color:#23272a; background:#fff; font-weight:bold;">{{ $s->nom }}</option>
                    @endforeach
                </select>
                <button type="submit" class="ml-2 px-5 py-2 bg-gradient-to-r from-[#e2001a] to-[#b80016] text-white font-extrabold rounded shadow-lg hover:from-[#b80016] hover:to-[#e2001a] focus:outline-none focus:ring-2 focus:ring-[#6fcf97] transition">OK</button>
            @endif
        </form>
    </div>
    @foreach($pools as $pool)
        <div class="mb-8">
            <div class="text-2xl font-bold text-[#e2001a] uppercase mb-4">Pool {{ $pool->nom }}</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 overflow-x-auto min-w-0">
                @foreach($pool->equipes as $equipe)
                    <a href="{{ route('equipes.show', ['equipe' => $equipe->id]) }}" class="block bg-[#23272a] rounded-lg shadow-lg p-6 hover:bg-[#181d1f] transition group border border-[#31363a] min-w-0">
                        <div class="flex items-center gap-4 mb-2 min-w-0">
                            <x-team-logo :team="$equipe" :size="48" />
                            <span class="font-extrabold text-white text-lg group-hover:text-[#6fcf97] truncate">{{ $equipe->nom }}</span>
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
