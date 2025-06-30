@extends('layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Résultats des rencontres</h2>
    <div class="mb-4 flex flex-wrap gap-4 items-end">
        <form method="GET" action="{{ route('admin.rencontres.resultats') }}" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block font-semibold">Saison</label>
                <select name="saison_id" class="form-select w-40" onchange="this.form.submit()">
                    <option value="">Toutes</option>
                    @foreach($saisons as $s)
                        <option value="{{ $s->id }}" {{ (isset($saison_id) && $saison_id == $s->id) ? 'selected' : '' }}>{{ $s->annee }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold">Pool</label>
                <select name="pool_id" class="form-select w-40" onchange="this.form.submit()">
                    <option value="">Tous</option>
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
            <div>
                <label class="block font-semibold">Équipe</label>
                <select name="equipe_id" class="form-select w-40" onchange="this.form.submit()">
                    <option value="">Toutes</option>
                    @foreach($pools as $pool)
                        @foreach($pool->equipes as $equipe)
                            <option value="{{ $equipe->id }}" {{ (isset($equipe_id) && $equipe_id == $equipe->id) ? 'selected' : '' }}>{{ $equipe->nom }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    @if($rencontres->count())
        @foreach($rencontres as $journee => $matches)
            <h3 class="text-lg font-semibold mt-6 mb-2">Journée {{ $journee }}</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded shadow mb-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Équipe 1</th>
                            <th class="px-4 py-2">Score</th>
                            <th class="px-4 py-2">Équipe 2</th>
                            <th class="px-4 py-2">MVP</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matches as $rencontre)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $rencontre->date }}</td>
                                <td class="px-4 py-2">{{ $rencontre->equipe1->nom ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $rencontre->score_equipe1 ?? '-' }} - {{ $rencontre->score_equipe2 ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $rencontre->equipe2->nom ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    @if($rencontre->mvp_libre)
                                        <span class="italic text-blue-600 dark:text-blue-300">{{ $rencontre->mvp_libre }}</span>
                                    @elseif($rencontre->mvp)
                                        {{ $rencontre->mvp->nom }} {{ $rencontre->mvp->prenom }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.rencontres.editResultat', $rencontre) }}" class="text-blue-600 hover:underline">Saisir/Modifier résultat</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @else
        <div class="text-center py-4">Aucun résultat trouvé.</div>
    @endif
</div>
@endsection
