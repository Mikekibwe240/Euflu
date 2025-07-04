@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Liste des rencontres @if($saison) (Saison {{ $saison->annee ?? '' }}) @endif</h2>
    <div class="flex flex-wrap gap-4 mb-4">
        <a href="{{ route('admin.rencontres.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Ajouter une rencontre</a>
        <a href="/admin/matchs/generer" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Générer calendrier</a>
        <a href="{{ route('admin.rencontres.export', request()->all()) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">Exporter Excel</a>
        <a href="{{ route('admin.rencontres.exportPdf', request()->all()) }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Exporter PDF</a>
    </div>
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif

    <form method="GET" action="{{ route('admin.rencontres.index') }}" class="mb-4 flex flex-wrap gap-4 items-end bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Pool</label>
            <select name="pool_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                <option value="">Tous</option>
                @if(isset($pools))
                    @foreach($pools as $pool)
                        <option value="{{ $pool->id }}" {{ request('pool_id') == $pool->id ? 'selected' : '' }}>{{ $pool->nom }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Équipe</label>
            <select name="equipe_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                <option value="">Toutes</option>
                @if(isset($equipes))
                    @foreach($equipes as $equipe)
                        <option value="{{ $equipe->id }}" {{ request('equipe_id') == $equipe->id ? 'selected' : '' }}>{{ $equipe->nom }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Saison</label>
            <select name="saison_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                <option value="">Actuelle</option>
                @if(isset($saisons))
                    @foreach($saisons as $s)
                        <option value="{{ $s->id }}" {{ request('saison_id') == $s->id ? 'selected' : '' }}>{{ $s->annee ?? $s->nom }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Journée</label>
            <input type="number" name="journee" value="{{ request('journee') }}" class="form-input w-24 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
        </div>
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Type de rencontre</label>
            <select name="type_rencontre" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                <option value="">Tous</option>
                <option value="championnat" {{ request('type_rencontre') == 'championnat' ? 'selected' : '' }}>Championnat</option>
                <option value="amical" {{ request('type_rencontre') == 'amical' ? 'selected' : '' }}>Amical</option>
                <option value="externe" {{ request('type_rencontre') == 'externe' ? 'selected' : '' }}>Externe</option>
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">État du match</label>
            <select name="etat_match" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                <option value="">Tous</option>
                <option value="joue" {{ request('etat_match') == 'joue' ? 'selected' : '' }}>Match joué</option>
                <option value="non_joue" {{ request('etat_match') == 'non_joue' ? 'selected' : '' }}>Match non joué</option>
            </select>
        </div>
        <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-900 transition">Rechercher</button>
    </form>

    <div class="mb-4 flex flex-wrap gap-4 items-end">
        <input type="text" id="search-rencontres" placeholder="Recherche rapide..." class="form-input w-64 rounded border-gray-300 dark:bg-gray-700 dark:text-white" />
    </div>

    @php
        // Regrouper les rencontres par journée
        $rencontresParJournee = $rencontres->getCollection()->groupBy('journee');
    @endphp
    <div id="rencontres-tables">
    @foreach($rencontresParJournee as $journee => $liste)
        @php
            $titreJournee = $journee ? "Journée $journee" : 'Hors journées / Autres rencontres';
        @endphp
        <h3 class="text-lg font-semibold mt-6 mb-2">{{ $titreJournee }}</h3>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded shadow table-fixed rencontres-table">
                <thead>
                    <tr>
                        <th class="px-4 py-2 w-24 text-center">Date</th>
                        <th class="px-4 py-2 w-20 text-center">Heure</th>
                        <th class="px-4 py-2 w-28 text-center">Pool</th>
                        <th class="px-4 py-2 w-40 text-center">Équipe 1</th>
                        <th class="px-2 py-2 w-10 text-center">vs</th>
                        <th class="px-4 py-2 w-40 text-center">Équipe 2</th>
                        <th class="px-4 py-2 w-32 text-center">Stade</th>
                        <th class="px-4 py-2 w-20 text-center">Score</th>
                        <th class="px-4 py-2 w-32 text-center">MVP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($liste as $rencontre)
                        <tr class="border-t text-center align-middle hover:bg-blue-50 dark:hover:bg-blue-900 cursor-pointer" onclick="window.location='{{ route('admin.rencontres.show', $rencontre) }}'">
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
                                    <span class="italic text-blue-600 dark:text-blue-300">{{ $rencontre->mvp_libre }}</span>
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
    <button onclick="window.history.back()" class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 transition">← Retour</button>
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
