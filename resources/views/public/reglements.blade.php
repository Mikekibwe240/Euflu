@extends('layouts.public')

@section('title', 'Règlements')

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
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-8 text-center uppercase tracking-wider drop-shadow">Règlements du Championnat</h1>
    <form method="GET" class="mb-8 flex flex-wrap gap-4 justify-center">
        <select name="saison_id" class="px-4 py-2 rounded text-black bg-white border-2 border-[#6fcf97] focus:outline-none focus:ring-2 focus:ring-[#6fcf97] min-w-[180px]">
            <option value="" style="color: #000; background: #fff;">Toutes saisons</option>
            @foreach($saisons as $saison)
                <option value="{{ $saison->id }}" style="color: #000; background: #fff;" @selected(request('saison_id', $saison?->id) == $saison->id)>
                    {{ $saison->nom ?? $saison->annee }}
                </option>
            @endforeach
        </select>
        <input type="text" name="titre" value="{{ request('titre') }}" placeholder="Titre..." class="px-4 py-2 rounded text-black bg-white border-2 border-[#6fcf97] focus:outline-none focus:ring-2 focus:ring-[#6fcf97] min-w-[180px]" />
        <input type="text" name="auteur" value="{{ request('auteur') }}" placeholder="Auteur..." class="px-4 py-2 rounded text-black bg-white border-2 border-[#6fcf97] focus:outline-none focus:ring-2 focus:ring-[#6fcf97] min-w-[180px]" />
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Recherche..." class="px-4 py-2 rounded text-black bg-white border-2 border-[#6fcf97] focus:outline-none focus:ring-2 focus:ring-[#6fcf97] min-w-[180px]" />
        <button type="submit" class="inline-block bg-[#6fcf97] text-[#23272a] font-bold px-6 py-2 rounded-full shadow hover:bg-[#23272a] hover:text-[#6fcf97] transition-all duration-300 font-inter">Filtrer</button>
    </form>
    <div class="overflow-x-auto bg-[#181d1f] rounded-lg shadow-lg border border-[#31363a]">
        <table class="min-w-full divide-y divide-gray-700 text-white">
            <thead class="bg-[#23272a]">
                <tr>
                    <th class="px-4 py-3 text-left font-extrabold uppercase">N°</th>
                    <th class="px-4 py-3 text-left font-extrabold uppercase">Titre</th>
                    <th class="px-4 py-3 text-left font-extrabold uppercase">Saison</th>
                    <th class="px-4 py-3 text-left font-extrabold uppercase">Auteur</th>
                    <th class="px-4 py-3 text-left font-extrabold uppercase">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reglements as $reglement)
                    <tr class="hover:bg-[#23272a] transition cursor-pointer border-b border-[#31363a]" onclick="window.location.href='{{ route('public.reglements.show', $reglement->id) }}'">
                        <td class="px-4 py-3 font-semibold">N° {{ $reglement->id }}</td>
                        <td class="px-4 py-3">{{ $reglement->titre }}</td>
                        <td class="px-4 py-3">{{ $reglement->saison->nom ?? $reglement->saison->annee ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $reglement->user->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $reglement->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucun règlement trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-8 flex justify-center">
        {{ $reglements->links() }}
    </div>
</div>
@endsection
