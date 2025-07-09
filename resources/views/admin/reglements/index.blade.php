@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4 text-white">Règlements</h2>
    <div class="flex flex-wrap gap-4 mb-4">
        <button onclick="window.history.back()" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">← Retour</button>
        <a href="{{ route('admin.reglements.create') }}" class="bg-green-700 text-white px-4 py-2 rounded-lg shadow hover:bg-green-800 border border-green-700 transition">Ajouter un règlement</a>
        <a href="{{ route('admin.reglements.exportPdf', request()->all()) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">Exporter PDF</a>
    </div>
    <form method="GET" action="{{ route('admin.reglements.index') }}" class="mb-4 flex flex-wrap gap-4 items-end bg-bl-card p-4 rounded-lg shadow border border-bl-border">
        <div>
            <label class="block font-semibold text-gray-200">Saison</label>
            <select name="saison_id" class="form-select w-40 rounded border-bl-border bg-gray-800 text-white">
                <option value="all" {{ request('saison_id') === 'all' ? 'selected' : '' }}>Toutes</option>
                @foreach($saisons as $s)
                    <option value="{{ $s->id }}" {{ request('saison_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->nom ?? $s->annee }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-200">Titre</label>
            <input type="text" name="titre" class="form-input w-40 rounded border-bl-border bg-gray-800 text-white" placeholder="Titre" value="{{ request('titre') }}">
        </div>
        <div>
            <label class="block font-semibold text-gray-200">Auteur</label>
            <input type="text" name="auteur" class="form-input w-40 rounded border-bl-border bg-gray-800 text-white" placeholder="Auteur" value="{{ request('auteur') }}">
        </div>
        <div>
            <label class="block font-semibold text-gray-200">Recherche</label>
            <input type="text" name="q" class="form-input w-60 rounded border-bl-border bg-gray-800 text-white" placeholder="Contenu..." value="{{ request('q') }}">
        </div>
        <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-900 transition">Filtrer</button>
        <a href="{{ route('admin.reglements.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded ml-2">Réinitialiser</a>
    </form>
    @if(session('success'))
        <x-alert type="success" :message="session('success')" class="mb-4" />
    @endif
    <div class="overflow-x-auto rounded shadow">
    <table class="min-w-full bg-bl-card text-white rounded table-fixed border border-bl-border">
        <thead class="bg-[#23272a]">
            <tr>
                <th class="px-4 py-2 w-16 text-center text-white">N°</th>
                <th class="px-4 py-2 w-40 text-center text-white">Titre</th>
                <th class="px-4 py-2 w-32 text-center text-white">Saison</th>
                <th class="px-4 py-2 w-32 text-center text-white">Date</th>
                <th class="px-4 py-2 w-32 text-center text-white">Auteur</th>
                <th class="px-4 py-2 w-32 text-center text-white">Modifié par</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reglements as $reglement)
                <tr class="border-t border-bl-border hover:bg-bl-dark transition text-center align-middle cursor-pointer" onclick="window.location='{{ route('admin.reglements.show', $reglement) }}'">
                    <td class="px-4 py-2 font-bold">{{ $reglement->id }}</td>
                    <td class="px-4 py-2 font-semibold text-white underline">{{ $reglement->titre }}</td>
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
    <div class="mt-4 flex justify-center">
        {{ $reglements->links() }}
    </div>
</div>
@endsection
