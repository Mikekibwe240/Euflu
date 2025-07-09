@extends('layouts.admin')

@section('title', 'Gestion des Joueurs')

@section('header')
    Gestion des Joueurs (Saison : {{ $saison?->nom ?? 'Aucune' }})
@endsection

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 shadow">{{ session('success') }}</div>
@endif
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.joueurs.create') }}" class="bg-green-700 text-white px-4 py-2 rounded-lg shadow hover:bg-green-800 border border-green-700 transition">Ajouter un joueur</a>
    <div class="flex gap-2">
        <a href="{{ route('admin.joueurs.export', request()->all()) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">Exporter Excel</a>
        <a href="{{ route('admin.joueurs.exportPdf', request()->all()) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">Exporter PDF</a>
    </div>
</div>
<button onclick="window.history.back()" class="mb-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 border border-yellow-500 transition">← Retour</button>
<form method="GET" action="{{ route('admin.joueurs.index') }}" class="mb-4 flex flex-wrap gap-4 items-end bg-bl-card p-4 rounded-lg shadow border border-bl-border">
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
    <div>
        <label class="block font-semibold text-gray-700 dark:text-gray-200">Saison</label>
        <select name="saison_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
            <option value="all" {{ request('saison_id', 'all') === 'all' ? 'selected' : '' }}>Toutes</option>
            @if(isset($saisons))
                @foreach($saisons as $s)
                    <option value="{{ $s->id }}" {{ request('saison_id') == $s->id ? 'selected' : '' }}>{{ $s->annee ?? $s->nom }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div>
        <label class="block font-semibold text-gray-700 dark:text-gray-200">Recherche</label>
        <input type="text" name="nom" value="{{ request('nom') }}" placeholder="Nom, prénom..." class="form-input w-64 rounded border-gray-300 dark:bg-gray-700 dark:text-white" />
    </div>
    <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-900 transition">Rechercher</button>
</form>
<div class="mb-4 flex flex-wrap gap-4 items-end">
</div>
<table class="min-w-full bg-bl-card rounded-lg shadow mt-4 table-fixed joueurs-table border border-bl-border">
    <thead class="bg-[#23272a]">
        <tr>
            <th class="py-2 px-4 w-20 text-center text-white">Photo</th>
            <th class="py-2 px-4 w-32 text-center text-white">Nom</th>
            <th class="py-2 px-4 w-32 text-center text-white">Prénom</th>
            <th class="py-2 px-4 w-32 text-center text-white">Date naissance</th>
            <th class="py-2 px-4 w-24 text-center text-white">Poste</th>
            <th class="py-2 px-4 w-40 text-center text-white">Équipe</th>
            <th class="py-2 px-4 w-28 text-center text-white">Licence</th>
            <th class="py-2 px-4 w-20 text-center text-white">Dossard</th>
            <th class="py-2 px-4 w-28 text-center text-white">Nationalité</th>
        </tr>
    </thead>
    <tbody>
        @foreach($joueurs as $joueur)
        @php
            $rowClass = 'border-b border-bl-border text-center align-middle hover:bg-bl-dark transition cursor-pointer';
        @endphp
        <tr class="{{ $rowClass }}" onclick="window.location='{{ route('admin.joueurs.show', $joueur) }}'">
            <td class="py-2 px-4">
                @if($joueur->photo)
                    <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo" class="h-10 w-10 rounded-full object-cover border border-bl-border bg-bl-card mx-auto" onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'h-10 w-10 rounded-full bg-[#23272a] flex items-center justify-center mx-auto\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#b0b0b0\' viewBox=\'0 0 24 24\' class=\'h-8 w-8\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z\'/></svg></div>'">
                @else
                    <div class="h-10 w-10 rounded-full bg-[#23272a] flex items-center justify-center mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-8 w-8">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                        </svg>
                    </div>
                @endif
            </td>
            <td class="py-2 px-4 font-semibold text-white">{{ $joueur->nom }}</td>
            <td class="py-2 px-4 text-white">{{ $joueur->prenom }}</td>
            <td class="py-2 px-4 text-white">{{ $joueur->date_naissance }}</td>
            <td class="py-2 px-4 text-white">{{ $joueur->poste }}</td>
            <td class="py-2 px-4 text-white">{{ $joueur->equipe ? $joueur->equipe->nom : 'Libre' }}</td>
            <td class="py-2 px-4 font-mono text-white">{{ $joueur->numero_licence ?? '-' }}</td>
            <td class="py-2 px-4 font-mono text-white">{{ $joueur->numero_dossard ?? '-' }}</td>
            <td class="py-2 px-4 text-white">{{ $joueur->nationalite ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-6 flex justify-center">
    {{ $joueurs->links() }}
</div>
@endsection

@section('scripts')
@endsection
