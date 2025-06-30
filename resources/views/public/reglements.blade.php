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
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Règlements du Championnat</h1>
    <form method="GET" class="mb-6 flex flex-wrap gap-4 justify-center">
        <select name="saison_id" class="input input-bordered dark:bg-gray-800 dark:text-white">
            <option value="">Toutes saisons</option>
            @foreach($saisons as $saison)
                <option value="{{ $saison->id }}" @selected(request('saison_id') == $saison->id)>
                    {{ $saison->nom ?? $saison->annee }}
                </option>
            @endforeach
        </select>
        <input type="text" name="titre" value="{{ request('titre') }}" placeholder="Titre..." class="input input-bordered dark:bg-gray-800 dark:text-white">
        <input type="text" name="auteur" value="{{ request('auteur') }}" placeholder="Auteur..." class="input input-bordered dark:bg-gray-800 dark:text-white">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Recherche..." class="input input-bordered dark:bg-gray-800 dark:text-white">
        <button type="submit" class="inline-block bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 font-bold px-6 py-2 rounded-full shadow hover:bg-primary-700 dark:hover:bg-gray-300 transition-all duration-300 font-inter">Filtrer</button>
    </form>
    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left">N°</th>
                    <th class="px-4 py-2 text-left">Titre</th>
                    <th class="px-4 py-2 text-left">Saison</th>
                    <th class="px-4 py-2 text-left">Auteur</th>
                    <th class="px-4 py-2 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reglements as $reglement)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition cursor-pointer" onclick="window.location.href='{{ route('public.reglements.show', $reglement->id) }}'">
                        <td class="px-4 py-2 font-semibold">N° {{ $reglement->id }}</td>
                        <td class="px-4 py-2">{{ $reglement->titre }}</td>
                        <td class="px-4 py-2">{{ $reglement->saison->nom ?? $reglement->saison->annee ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $reglement->user->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $reglement->created_at->format('d/m/Y') }}</td>
                    </tr>
                    <tr id="reglement-{{ $reglement->id }}" class="hidden bg-gray-50 dark:bg-gray-800">
                        <td colspan="5" class="px-4 py-4">
                            <div class="prose dark:prose-invert max-w-none">
                                {!! nl2br(e($reglement->contenu)) !!}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">Aucun règlement trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $reglements->withQueryString()->links() }}</div>
    </div>
</div>
<script>
function showReglement(id) {
    document.querySelectorAll('tr[id^="reglement-"]').forEach(tr => tr.classList.add('hidden'));
    const row = document.getElementById('reglement-' + id);
    if(row) row.classList.toggle('hidden');
}
</script>
@endsection
