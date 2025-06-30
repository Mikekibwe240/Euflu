@extends('layouts.admin')

@section('title', 'Gestion des Joueurs')

@section('header')
    Gestion des Joueurs (Saison : {{ $saison?->nom ?? 'Aucune' }})
@endsection

@section('content')
@if(session('success'))
    <x-alert type="success" :message="session('success')" />
@endif
@if(session('error'))
    <x-alert type="error" :message="session('error')" />
@endif
@if($errors->any())
    <x-alert type="error" :message="$errors->first()" />
@endif
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.joueurs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">Ajouter un joueur</a>
    <div class="flex gap-2">
        <a href="{{ route('admin.joueurs.export', request()->all()) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 transition">Exporter Excel</a>
        <a href="{{ route('admin.joueurs.exportPdf', request()->all()) }}" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition">Exporter PDF</a>
    </div>
</div>
<button onclick="window.history.back()" class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 transition">← Retour</button>
<form method="GET" action="{{ route('admin.joueurs.index') }}" class="mb-4 flex flex-wrap gap-4 items-end bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
    <div>
        <label class="block font-semibold text-gray-700 dark:text-gray-200">Équipe</label>
        <select name="equipe_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
            <option value="">Toutes</option>
            <option value="libre" {{ request('equipe_id') === 'libre' ? 'selected' : '' }}>Libres (sans équipe)</option>
            @foreach($equipes as $equipe)
                <option value="{{ $equipe->id }}" {{ request('equipe_id') == $equipe->id ? 'selected' : '' }}>{{ $equipe->nom }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-900 transition">Rechercher</button>
</form>
<div class="mb-4 flex flex-wrap gap-4 items-end">
    <input type="text" id="search-joueurs" placeholder="Recherche rapide..." class="form-input w-64 rounded border-gray-300 dark:bg-gray-700 dark:text-white" />
</div>
<table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow mt-4 table-fixed joueurs-table">
    <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <th class="py-2 px-4 w-20 text-center">Photo</th>
            <th class="py-2 px-4 w-32 text-center">Nom</th>
            <th class="py-2 px-4 w-32 text-center">Prénom</th>
            <th class="py-2 px-4 w-32 text-center">Date naissance</th>
            <th class="py-2 px-4 w-24 text-center">Poste</th>
            <th class="py-2 px-4 w-40 text-center">Équipe</th>
        </tr>
    </thead>
    <tbody>
        @foreach($joueurs as $joueur)
        <tr class="border-b border-gray-200 dark:border-gray-700 text-center align-middle hover:bg-blue-50 dark:hover:bg-blue-900 transition cursor-pointer" onclick="window.location='{{ route('admin.joueurs.show', $joueur) }}'">
            <td class="py-2 px-4">
                @if($joueur->photo)
                    <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo" class="h-10 w-10 rounded-full object-cover border border-gray-200 dark:border-gray-700 bg-white mx-auto" onerror="this.style.display='none'">
                @else
                    <span class="flex h-10 w-10 rounded-full bg-blue-100 text-blue-700 font-bold items-center justify-center mx-auto">{{ strtoupper(substr($joueur->nom,0,1)) }}</span>
                @endif
            </td>
            <td class="py-2 px-4 font-semibold text-blue-700 dark:text-blue-300">{{ $joueur->nom }}</td>
            <td class="py-2 px-4">{{ $joueur->prenom }}</td>
            <td class="py-2 px-4">{{ $joueur->date_naissance }}</td>
            <td class="py-2 px-4">{{ $joueur->poste }}</td>
            <td class="py-2 px-4">{{ $joueur->equipe ? $joueur->equipe->nom : 'Libre' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-6 flex justify-center">
    {{ $joueurs->links() }}
</div>
@endsection

@section('scripts')
<script>
document.getElementById('search-joueurs').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.joueurs-table tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
    });
});
</script>
@endsection
