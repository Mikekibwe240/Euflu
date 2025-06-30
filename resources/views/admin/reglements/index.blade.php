@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Règlements</h2>
    <button onclick="window.history.back()" class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 transition">← Retour</button>
    <a href="{{ route('admin.reglements.create') }}" class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Ajouter un règlement</a>
    <a href="{{ route('admin.reglements.exportPdf', request()->all()) }}" class="mb-4 inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Exporter PDF</a>
    <form method="GET" action="{{ route('admin.reglements.index') }}" class="mb-4 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block font-semibold">Saison</label>
            <select name="saison_id" class="form-select w-40 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700">
                <option value="">Toutes</option>
                @foreach($saisons as $s)
                    <option value="{{ $s->id }}" {{ request('saison_id') == $s->id ? 'selected' : '' }}>{{ $s->annee }}
                        @if($s->etat === 'ouverte')
                            <span class="inline-block bg-green-500 text-white text-xs px-2 py-1 rounded ml-2">En cours</span>
                        @else
                            <span class="inline-block bg-red-500 text-white text-xs px-2 py-1 rounded ml-2">Clôturée</span>
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-semibold">Titre</label>
            <input type="text" name="titre" class="form-input w-40 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" placeholder="Titre" value="{{ request('titre') }}">
        </div>
        <div>
            <label class="block font-semibold">Auteur</label>
            <input type="text" name="auteur" class="form-input w-40 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" placeholder="Auteur" value="{{ request('auteur') }}">
        </div>
        <div>
            <label class="block font-semibold">Recherche</label>
            <input type="text" name="q" class="form-input w-60 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" placeholder="Contenu..." value="{{ request('q') }}">
        </div>
        <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded">Filtrer</button>
        <a href="{{ route('admin.reglements.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded ml-2">Réinitialiser</a>
    </form>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4 border border-green-300 dark:bg-green-900 dark:text-green-200 dark:border-green-700">
            {{ session('success') }}
        </div>
    @endif
    <div class="overflow-x-auto rounded shadow">
    <table class="min-w-full bg-white dark:bg-gray-800 rounded text-gray-900 dark:text-gray-100 table-fixed">
        <thead>
            <tr>
                <th class="px-4 py-2 w-16 text-center">N°</th>
                <th class="px-4 py-2 w-40 text-center">Titre</th>
                <th class="px-4 py-2 w-32 text-center">Saison</th>
                <th class="px-4 py-2 w-32 text-center">Date</th>
                <th class="px-4 py-2 w-32 text-center">Auteur</th>
                <th class="px-4 py-2 w-32 text-center">Modifié par</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reglements as $reglement)
                <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition text-center align-middle cursor-pointer" onclick="window.location='{{ route('admin.reglements.show', $reglement) }}'">
                    <td class="px-4 py-2 font-bold">{{ $reglement->id }}</td>
                    <td class="px-4 py-2 font-semibold">{{ $reglement->titre }}</td>
                    <td class="px-4 py-2">{{ $reglement->saison->annee ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $reglement->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-2">{{ $reglement->user->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $reglement->updatedBy->name ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="py-4 text-center text-gray-500">Aucun règlement trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
    <div class="mt-4">
        {{ $reglements->links() }}
    </div>
</div>
@endsection
