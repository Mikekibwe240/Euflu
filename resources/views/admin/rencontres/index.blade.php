@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-extrabold mb-6 text-white tracking-wide">Liste des rencontres</h2>
    <div class="flex flex-wrap gap-4 mb-4">
        <a href="{{ route('admin.rencontres.create') }}" class="bg-green-700 text-white px-4 py-2 rounded-lg shadow hover:bg-green-800 border border-green-700 transition">Ajouter une rencontre</a>
        <a href="/admin/matchs/generer" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">Générer calendrier</a>
        <a href="{{ route('admin.rencontres.export', request()->all()) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">Exporter Excel</a>
        <a href="{{ route('admin.rencontres.exportPdf', request()->all()) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">Exporter PDF</a>
    </div>
    <button onclick="window.history.back()" class="mb-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 border border-yellow-500 transition">← Retour</button>
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif

    <form method="GET" action="{{ route('admin.rencontres.index') }}" class="mb-4 flex flex-wrap gap-4 items-end bg-bl-card p-4 rounded-lg shadow border border-bl-border">
        <div>
            <label class="block font-semibold text-gray-200">Pool</label>
            <select name="pool_id" class="form-select w-40 rounded border-bl-border bg-gray-800 text-white">
                <option value="">Tous</option>
                @if(isset($pools))
                    @foreach($pools as $pool)
                        <option value="{{ $pool->id }}" {{ request('pool_id') == $pool->id ? 'selected' : '' }}>{{ $pool->nom }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-200">Équipe</label>
            <select name="equipe_id" class="form-select w-40 rounded border-bl-border bg-gray-800 text-white">
                <option value="">Toutes</option>
                @if(isset($equipes))
                    @foreach($equipes as $equipe)
                        <option value="{{ $equipe->id }}" {{ request('equipe_id') == $equipe->id ? 'selected' : '' }}>{{ $equipe->nom }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-200">Saison</label>
            <select name="saison_id" class="form-select w-40 rounded border-bl-border bg-gray-800 text-white">
                <option value="">Actuelle</option>
                @if(isset($saisons))
                    @foreach($saisons as $s)
                        <option value="{{ $s->id }}" {{ request('saison_id') == $s->id ? 'selected' : '' }}>{{ $s->annee ?? $s->nom }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-200">Journée</label>
            <input type="number" name="journee" value="{{ request('journee') }}" class="form-input w-24 rounded border-bl-border bg-gray-800 text-white">
        </div>
        <div>
            <label class="block font-semibold text-gray-200">Type de rencontre</label>
            <select name="type_rencontre" class="form-select w-40 rounded border-bl-border bg-gray-800 text-white">
                <option value="">Tous</option>
                <option value="championnat" {{ request('type_rencontre') == 'championnat' ? 'selected' : '' }}>Championnat</option>
                <option value="amical" {{ request('type_rencontre') == 'amical' ? 'selected' : '' }}>Amical</option>
                <option value="externe" {{ request('type_rencontre') == 'externe' ? 'selected' : '' }}>Externe</option>
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-200">État du match</label>
            <select name="etat_match" class="form-select w-40 rounded border-bl-border bg-gray-800 text-white">
                <option value="">Tous</option>
                <option value="joue" {{ request('etat_match') == 'joue' ? 'selected' : '' }}>Match joué</option>
                <option value="non_joue" {{ request('etat_match') == 'non_joue' ? 'selected' : '' }}>Match non joué</option>
            </select>
        </div>
        <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-900 transition">Rechercher</button>
    </form>

    @php
        // Regrouper les rencontres par journée
        $rencontresParJournee = $rencontres->getCollection()->groupBy('journee');
    @endphp
    <div id="rencontres-tables">
    @foreach($rencontresParJournee as $journee => $liste)
        @php
            $titreJournee = $journee ? "Journée $journee" : 'Hors journées / Autres rencontres';
        @endphp
        <h3 class="text-lg font-semibold mt-6 mb-2 text-white">{{ $titreJournee }}</h3>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full bg-bl-card text-white rounded shadow table-fixed rencontres-table border border-bl-border">
                <thead class="bg-[#23272a]">
                    <tr>
                        <th class="px-4 py-2 w-24 text-center text-white">Date</th>
                        <th class="px-4 py-2 w-20 text-center text-white">Heure</th>
                        <th class="px-4 py-2 w-28 text-center text-white">Pool</th>
                        <th class="px-4 py-2 w-40 text-center text-white">Équipe 1</th>
                        <th class="px-2 py-2 w-10 text-center text-white">vs</th>
                        <th class="px-4 py-2 w-40 text-center text-white">Équipe 2</th>
                        <th class="px-4 py-2 w-32 text-center text-white">Stade</th>
                        <th class="px-4 py-2 w-20 text-center text-white">Score</th>
                        <th class="px-4 py-2 w-32 text-center text-white">MVP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($liste as $rencontre)
                        <tr class="border-t border-bl-border text-center align-middle hover:bg-bl-dark transition cursor-pointer" onclick="window.location='{{ route('admin.rencontres.show', $rencontre) }}'">
                            <td class="px-4 py-2">{{ $rencontre->date }}</td>
                            <td class="px-4 py-2">{{ $rencontre->heure }}</td>
                            <td class="px-4 py-2">{{ $rencontre->pool->nom ?? '-' }}</td>
                            <td class="px-4 py-2 font-semibold">
                                <div class="flex items-center gap-2 justify-center min-h-[32px]">
                                    @if($rencontre->equipe1)
                                        <x-team-logo :team="$rencontre->equipe1" size="32" />
                                    @elseif($rencontre->equipe1_libre)
                                        <x-team-logo :team="(object)['nom'=>$rencontre->equipe1_libre]" size="32" />
                                    @else
                                        <x-team-logo :team="null" size="32" />
                                    @endif
                                    <span class="truncate max-w-[120px] align-middle text-sm font-semibold">{{ $rencontre->equipe1->nom ?? $rencontre->equipe1_libre ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-2 py-2 font-bold text-lg">vs</td>
                            <td class="px-4 py-2 font-semibold">
                                <div class="flex items-center gap-2 justify-center min-h-[32px]">
                                    @if($rencontre->equipe2)
                                        <x-team-logo :team="$rencontre->equipe2" size="32" />
                                    @elseif($rencontre->equipe2_libre)
                                        <x-team-logo :team="(object)['nom'=>$rencontre->equipe2_libre]" size="32" />
                                    @else
                                        <x-team-logo :team="null" size="32" />
                                    @endif
                                    <span class="truncate max-w-[120px] align-middle text-sm font-semibold">{{ $rencontre->equipe2->nom ?? $rencontre->equipe2_libre ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-2">{{ $rencontre->stade }}</td>
                            <td class="px-4 py-2">
                                @if(!is_null($rencontre->score_equipe1) && !is_null($rencontre->score_equipe2))
                                    <span class="font-bold">{{ $rencontre->score_equipe1 }} - {{ $rencontre->score_equipe2 }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($rencontre->mvp_libre)
                                    <span class="italic text-blue-400">{{ $rencontre->mvp_libre }}</span>
                                @elseif($rencontre->mvp)
                                    {{ $rencontre->mvp->nom }} {{ $rencontre->mvp->prenom }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
    </div>
    <div class="mt-6 flex justify-center">
        {{ $rencontres->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('search-rencontres').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.rencontres-table tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
    });
});
</script>
@endsection
