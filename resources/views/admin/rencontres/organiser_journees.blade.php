@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Organiser les journées</h2>
    @if(session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-2 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif
    <form method="GET" action="{{ route('admin.rencontres.organiserJournees') }}" class="mb-4 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block font-semibold">Saison</label>
            <select name="saison_id" class="form-select w-40" onchange="this.form.submit()">
                <option value="">Sélectionner</option>
                @foreach($saisons as $s)
                    <option value="{{ $s->id }}" {{ (isset($saison_id) && $saison_id == $s->id) ? 'selected' : '' }}>{{ $s->annee }}</option>
                @endforeach
            </select>
        </div>
    </form>
    @if($pools->count())
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="px-4 py-2">Pool</th>
                    <th class="px-4 py-2">Nombre d'équipes</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pools as $pool)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $pool->nom }}</td>
                        <td class="px-4 py-2">{{ $pool->equipes_count }}</td>
                        <td class="px-4 py-2">
                            @if($pool->equipes_count % 2 == 0 || $pool->equipes_count == 14)
                                <form action="{{ route('admin.rencontres.genererJournees', $pool) }}" method="POST" onsubmit="return confirm('Générer toutes les journées pour ce pool ?')">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">Organiser les journées</button>
                                </form>
                            @else
                                <span class="text-gray-500">Nombre d'équipes non valide</span>
                            @endif
                            @if(isset($journeesByPool[$pool->id]) && count($journeesByPool[$pool->id]))
                                <div class="mt-2 text-xs text-gray-700">
                                    <strong>Journées générées :</strong>
                                    @foreach($journeesByPool[$pool->id] as $j)
                                        <span class="inline-block bg-gray-200 px-2 py-1 rounded mr-1">Journée {{ $j }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-gray-500">Sélectionnez une saison pour voir les pools.</div>
    @endif
</div>
@endsection
