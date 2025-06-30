@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Statistiques Équipes</h2>
    <form method="GET" action="{{ route('statistiques_equipes.index') }}" class="mb-4 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block font-semibold">Saison</label>
            <select name="saison_id" class="form-select w-40">
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
        <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded">Filtrer</button>
    </form>
    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr>
                <th class="px-4 py-2">Équipe</th>
                <th class="px-4 py-2">Points</th>
                <th class="px-4 py-2">Victoires</th>
                <th class="px-4 py-2">Nuls</th>
                <th class="px-4 py-2">Défaites</th>
                <th class="px-4 py-2">Buts</th>
                <th class="px-4 py-2">Cartons</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stats as $stat)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $stat->equipe->nom }}</td>
                    <td class="px-4 py-2">{{ $stat->points }}</td>
                    <td class="px-4 py-2">{{ $stat->victoires }}</td>
                    <td class="px-4 py-2">{{ $stat->nuls }}</td>
                    <td class="px-4 py-2">{{ $stat->defaites }}</td>
                    <td class="px-4 py-2">{{ $stat->buts }}</td>
                    <td class="px-4 py-2">{{ $stat->cartons }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-4">Aucune statistique trouvée.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
