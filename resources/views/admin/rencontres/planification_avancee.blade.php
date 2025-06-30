@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Planification avancée des journées</h2>
    <form method="GET" action="{{ route('admin.rencontres.planificationAvancee') }}" class="mb-4 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block font-semibold">Saison</label>
            <select name="saison_id" class="form-select w-40" onchange="this.form.submit()">
                <option value="">Sélectionner</option>
                @foreach($saisons as $s)
                    <option value="{{ $s->id }}" {{ (isset($saison_id) && $saison_id == $s->id) ? 'selected' : '' }}>{{ $s->annee }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-semibold">Pool</label>
            <select name="pool_id" class="form-select w-40" onchange="this.form.submit()">
                <option value="">Sélectionner</option>
                @foreach($pools as $pool)
                    <option value="{{ $pool->id }}" {{ (isset($pool_id) && $pool_id == $pool->id) ? 'selected' : '' }}>{{ $pool->nom }}</option>
                @endforeach
            </select>
        </div>
        @if($journees->count())
        <div>
            <label class="block font-semibold">Journée</label>
            <select name="journee" class="form-select w-32" onchange="this.form.submit()">
                <option value="">Toutes</option>
                @foreach($journees as $j)
                    <option value="{{ $j }}" {{ request('journee') == $j ? 'selected' : '' }}>Journée {{ $j }}</option>
                @endforeach
            </select>
        </div>
        @endif
    </form>
    @if($rencontres->count())
    <form method="POST" action="{{ route('admin.rencontres.planificationAvancee') }}">
        @csrf
        <input type="hidden" name="saison_id" value="{{ $saison_id }}">
        <input type="hidden" name="pool_id" value="{{ $pool_id }}">
        <input type="hidden" name="journee" value="{{ request('journee') }}">
    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr>
                <th class="px-4 py-2">Journée</th>
                <th class="px-4 py-2">Équipe 1</th>
                <th class="px-4 py-2">Équipe 2</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Heure</th>
                <th class="px-4 py-2">Stade</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rencontres as $r)
            <tr>
                <td class="px-4 py-2">{{ $r->journee }}</td>
                <td class="px-4 py-2">{{ $r->equipe1->nom ?? '-' }}</td>
                <td class="px-4 py-2">{{ $r->equipe2->nom ?? '-' }}</td>
                <td class="px-4 py-2">
                    <input type="date" name="dates[{{ $r->id }}]" value="{{ $r->date }}" class="form-input w-32">
                </td>
                <td class="px-4 py-2">
                    <input type="time" name="heures[{{ $r->id }}]" value="{{ $r->heure }}" class="form-input w-24">
                </td>
                <td class="px-4 py-2">
                    <input type="text" name="stades[{{ $r->id }}]" value="{{ $r->stade }}" class="form-input w-32">
                </td>
                <td class="px-4 py-2">
                    <a href="{{ route('admin.rencontres.edit', $r) }}" class="text-blue-600 hover:underline">Éditer</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Enregistrer les modifications</button>
    </div>
    </form>
    @elseif($pool_id)
        <div class="text-gray-500">Aucune rencontre générée pour ce pool.</div>
    @endif
    <div class="mb-4">
        <a href="{{ route('admin.rencontres.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter une rencontre hors calendrier</a>
    </div>
</div>
@endsection
