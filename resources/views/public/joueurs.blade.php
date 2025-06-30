@extends('layouts.public')
@section('title', 'Joueurs')
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
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-6 tracking-tight bundesliga-title">Joueurs</h1>
    <!-- Filtre par équipe ou poste (optionnel) -->
    {{-- <form method="GET" class="mb-6 flex flex-wrap gap-4 items-center">
        <select name="equipe" class="rounded px-3 py-2 bg-[#23272a] text-white border border-[#6fcf97]">
            <option value="">Toutes les équipes</option>
            {{-- @foreach($equipes as $equipe)
                <option value="{{ $equipe->id }}" {{ request('equipe') == $equipe->id ? 'selected' : '' }}>{{ $equipe->nom }}</option>
            @endforeach }}
        </select>
        <select name="poste" class="rounded px-3 py-2 bg-[#23272a] text-white border border-[#6fcf97]">
            <option value="">Tous les postes</option>
            {{-- @foreach($postes as $poste)
                <option value="{{ $poste }}" {{ request('poste') == $poste ? 'selected' : '' }}>{{ $poste }}</option>
            @endforeach }}
        </select>
        <button type="submit" class="ml-2 px-4 py-2 bg-[#E2001A] text-white font-bold rounded hover:bg-[#b80016] transition">Filtrer</button>
    </form> --}}

    <div class="overflow-x-auto rounded-lg shadow-lg bundesliga-table-wrapper">
        <table class="min-w-full text-sm text-left text-white bg-[#23272a] bundesliga-table">
            <thead class="bg-[#1a1d1f] text-[#6fcf97] uppercase text-xs font-bold">
                <tr>
                    <th scope="col" class="px-4 py-3">#</th>
                    <th scope="col" class="px-4 py-3">Photo</th>
                    <th scope="col" class="px-4 py-3">Nom</th>
                    <th scope="col" class="px-4 py-3">Équipe</th>
                    <th scope="col" class="px-4 py-3">Poste</th>
                    <th scope="col" class="px-4 py-3">Âge</th>
                    <th scope="col" class="px-4 py-3">Nationalité</th>
                </tr>
            </thead>
            <tbody>
                {{-- @forelse($joueurs as $index => $joueur) --}}
                <tr class="border-b border-[#333] hover:bg-[#2c3136] transition">
                    <td class="px-4 py-2 font-bold">1</td>
                    <td class="px-4 py-2">
                        <img src="/storage/img_euflu/joueurs/default.png" alt="Photo Joueur" class="h-10 w-10 rounded-full border-2 border-[#6fcf97] bg-white" />
                    </td>
                    <td class="px-4 py-2 font-semibold">Nom Joueur</td>
                    <td class="px-4 py-2 flex items-center gap-2">
                        <img src="/storage/img_euflu/equipes/default.png" alt="Logo Équipe" class="h-6 w-6 rounded-full bg-white border border-[#E2001A]" />
                        <span>Nom Équipe</span>
                    </td>
                    <td class="px-4 py-2">Poste</td>
                    <td class="px-4 py-2">23</td>
                    <td class="px-4 py-2">Pays</td>
                </tr>
                {{-- @empty --}}
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-400">Aucun joueur trouvé.</td>
                </tr>
                {{-- @endforelse --}}
            </tbody>
        </table>
    </div>
</div>
@endsection
