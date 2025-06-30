@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Gestion des Pools</h2>
    <form method="GET" action="{{ route('admin.pools.index') }}" class="mb-4 flex flex-wrap gap-4 items-end">
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
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Saison</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pools as $pool)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $pool->nom }}</td>
                    <td class="px-4 py-2">
                        {{ $pool->saison->annee ?? '-' }}
                        @if($pool->saison)
                            @if($pool->saison->etat === 'ouverte')
                                <span class="inline-block bg-green-500 text-white text-xs px-2 py-1 rounded ml-2">En cours</span>
                            @else
                                <span class="inline-block bg-red-500 text-white text-xs px-2 py-1 rounded ml-2">Clôturée</span>
                            @endif
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="2" class="text-center py-4">Aucun pool trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
