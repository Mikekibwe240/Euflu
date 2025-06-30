@extends('layouts.public')
@section('title', 'Fiche du match')
@section('content')
<div class="max-w-4xl mx-auto mt-10 mb-8">
    <div class="bg-[#23272a] rounded-xl shadow-lg border-b-4 border-[#6fcf97]">
        <div class="flex items-center justify-between px-6 pt-6">
            <a href="{{ url()->previous() }}" class="text-[#6fcf97] font-bold text-sm hover:underline flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                Matchday {{ $rencontre->journee ?? '-' }}
            </a>
            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider">{{ $rencontre->stade ?? '' }}</div>
        </div>
        <div class="text-center text-2xl font-extrabold text-white uppercase tracking-wider mt-2">HIGHLIGHTS</div>
        <div class="flex flex-col md:flex-row items-center justify-between px-6 py-6 gap-6">
            <div class="flex-1 flex flex-col items-center">
                <span class="text-white text-lg font-extrabold uppercase mb-2">{{ $rencontre->equipe1->nom ?? $rencontre->equipe1_libre ?? '-' }}</span>
                <x-team-logo :team="$rencontre->equipe1" size="56" />
            </div>
            <div class="flex flex-col items-center justify-center">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-black text-white px-4 py-2 rounded text-3xl font-extrabold tracking-widest border-2 border-[#23272a]">{{ $rencontre->score_equipe1 ?? '-' }}</span>
                    <span class="text-white text-2xl font-extrabold">-</span>
                    <span class="bg-[#e2001a] text-white px-4 py-2 rounded text-3xl font-extrabold tracking-widest border-2 border-[#e2001a]">{{ $rencontre->score_equipe2 ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-center gap-2">
                    <span class="text-xs text-gray-400 uppercase font-bold">FINAL</span>
                </div>
            </div>
            <div class="flex-1 flex flex-col items-center">
                <span class="text-white text-lg font-extrabold uppercase mb-2">{{ $rencontre->equipe2->nom ?? $rencontre->equipe2_libre ?? '-' }}</span>
                <x-team-logo :team="$rencontre->equipe2" size="56" />
            </div>
        </div>
        <div class="flex items-center justify-between px-6 pb-2">
            <div></div>
            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider">{{ $rencontre->date }} à {{ $rencontre->heure }}</div>
        </div>
        <div class="bg-[#181d1f] px-6 py-4 rounded-b-xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <div class="font-bold text-[#6fcf97] uppercase text-sm mb-1">Buteurs</div>
                    <ul class="text-white text-sm space-y-1">
                        @foreach($rencontre->buts as $but)
                            <li>
                                <span class="font-bold">{{ $but->joueur?->nom }} {{ $but->joueur?->prenom }}</span>
                                <span class="text-xs text-gray-400">{{ $but->minute ? $but->minute . "'" : '' }}</span>
                                <span class="text-xs text-gray-400">{{ $but->equipe_id == $rencontre->equipe1?->id ? $rencontre->equipe1?->nom : $rencontre->equipe2?->nom }}</span>
                            </li>
                        @endforeach
                        @if($rencontre->buts->isEmpty())
                            <li class="text-gray-500">Aucun but</li>
                        @endif
                    </ul>
                </div>
                <div class="flex-1">
                    <div class="font-bold text-[#e2001a] uppercase text-sm mb-1">Cartons</div>
                    <ul class="text-white text-sm space-y-1">
                        @foreach($rencontre->cartons as $carton)
                            <li>
                                <span class="font-bold">{{ $carton->joueur?->nom }} {{ $carton->joueur?->prenom }}</span>
                                <span class="text-xs text-gray-400">{{ $carton->minute ? $carton->minute . "'" : '' }}</span>
                                <span class="text-xs {{ $carton->type == 'jaune' ? 'text-yellow-400' : 'text-red-500' }}">{{ ucfirst($carton->type) }}</span>
                            </li>
                        @endforeach
                        @if($rencontre->cartons->isEmpty())
                            <li class="text-gray-500">Aucun carton</li>
                        @endif
                    </ul>
                </div>
                <div class="flex-1">
                    <div class="font-bold text-[#6fcf97] uppercase text-sm mb-1">Homme du match</div>
                    <div class="text-white text-lg font-extrabold">
                        {{ $rencontre->mvp?->nom ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('public.matchs.index') }}" class="text-[#6fcf97] font-bold text-sm hover:underline flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Retour à la liste des matchs
        </a>
    </div>
    <div class="flex justify-center mt-8">
        <a href="{{ route('public.match.pdf', ['id' => $rencontre->id]) }}" class="px-8 py-3 bg-[#23272a] border-2 border-[#6fcf97] text-white font-bold rounded hover:bg-[#6fcf97] hover:text-[#23272a] transition" target="_blank">Télécharger la feuille de match (PDF)</a>
    </div>
</div>
@endsection
