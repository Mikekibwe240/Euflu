@extends('layouts.admin')

@section('title', 'Fiche Joueur')

@section('content')
<div class="container mx-auto py-8">
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mb-8 flex flex-col md:flex-row items-center gap-8">
        <div class="flex-shrink-0 flex flex-col items-center">
            @if($joueur->photo)
                <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo {{ $joueur->nom }}" class="h-32 w-32 rounded-full object-cover border-4 border-blue-200 dark:border-blue-700 bg-white mb-4" onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'h-32 w-32 flex items-center justify-center rounded-full bg-gray-700 mb-4\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#b0b0b0\' viewBox=\'0 0 24 24\' class=\'h-24 w-24\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z\'/></svg></div>'">
            @else
                <div class="h-32 w-32 flex items-center justify-center rounded-full bg-gray-700 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-24 w-24">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                    </svg>
                </div>
            @endif
            <div class="text-xl font-semibold text-blue-800 dark:text-blue-200">{{ $joueur->nom }} {{ $joueur->prenom }}</div>
            <div class="text-gray-500 dark:text-gray-300">Équipe : {{ $joueur->equipe->nom ?? 'Sans équipe' }}</div>
            <div class="text-gray-500 dark:text-gray-300">Poste : {{ $joueur->poste ?? '-' }}</div>
            <div class="text-gray-500 dark:text-gray-300">Date de naissance : {{ $joueur->date_naissance ?? '-' }}</div>
            <div class="text-gray-500 dark:text-gray-300">Numéro de licence : <span class="font-mono">{{ $joueur->numero_licence ?? '-' }}</span></div>
            <div class="text-gray-500 dark:text-gray-300">Numéro (dossard) : <span class="font-mono">{{ $joueur->numero_dossard ?? '-' }}</span></div>
            <div class="text-gray-500 dark:text-gray-300">Nationalité : {{ $joueur->nationalite ?? '-' }}</div>
        </div>
        <div class="flex-1 w-full">
            <h2 class="text-2xl font-semibold text-blue-700 dark:text-blue-300 mb-4">Statistiques</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gradient-to-br from-blue-100 to-blue-300 dark:from-blue-900 dark:to-blue-700 rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-blue-800 dark:text-blue-200 mb-2">{{ isset($joueur->buts) ? $joueur->buts->count() : 0 }}</div>
                    <div class="text-lg text-blue-700 dark:text-blue-300 font-semibold">Buts marqués</div>
                </div>
                <div class="bg-gradient-to-br from-green-100 to-green-300 dark:from-green-900 dark:to-green-700 rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-green-800 dark:text-green-200 mb-2">{{ isset($joueur->buts) ? $joueur->buts->pluck('rencontre_id')->unique()->count() : 0 }}</div>
                    <div class="text-lg text-green-700 dark:text-green-300 font-semibold">Matchs joués</div>
                </div>
                <div class="bg-gradient-to-br from-yellow-100 to-yellow-300 dark:from-yellow-900 dark:to-yellow-700 rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-yellow-800 dark:text-yellow-200 mb-2">
                        @php
                            $ratio = (isset($joueur->buts) && $joueur->buts->pluck('rencontre_id')->unique()->count() > 0)
                                ? round($joueur->buts->count() / $joueur->buts->pluck('rencontre_id')->unique()->count(), 2)
                                : 0;
                        @endphp
                        {{ $ratio }}
                    </div>
                    <div class="text-lg text-yellow-700 dark:text-yellow-300 font-semibold">Ratio Buts / Match</div>
                </div>
            </div>
            <div class="flex gap-4 mb-6">
                <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 transition">Modifier</a>
                <form action="{{ route('admin.joueurs.destroy', $joueur) }}" method="POST" onsubmit="return confirm('Supprimer ce joueur ? Cette action est irréversible.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition">Supprimer</button>
                </form>
            </div>
            @if(!$joueur->equipe)
            <form action="{{ route('admin.joueurs.affecterEquipe', $joueur) }}" method="POST" class="mb-6 flex flex-col md:flex-row gap-4 items-center bg-blue-50 dark:bg-blue-900 p-4 rounded relative">
                @csrf
                <label for="equipe_search" class="font-semibold text-blue-800 dark:text-blue-200">Affecter à une équipe :</label>
                <div class="w-full md:w-80 relative">
                    <input type="text" name="equipe_search" id="equipe_search" placeholder="Rechercher une équipe..." autocomplete="off" class="p-2 border rounded w-full dark:bg-gray-700 dark:text-white" />
                    <div id="equipe_results" class="absolute z-10 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow mt-1 max-h-60 overflow-y-auto hidden"></div>
                    <input type="hidden" name="equipe_id" id="equipe_id" required />
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">Affecter</button>
            </form>
            <script>
                const equipes = @json($equipes);
                function renderEquipeResults(list) {
                    return list.length ? list.map(e => `<div class='flex items-center gap-3 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer' onclick='selectEquipe(${e.id}, "${e.nom.replace(/"/g, '&quot;')}")'>${e.logo?`<img src='/storage/${e.logo}' class='h-8 w-8 rounded-full object-cover'>`:`<span class=\'inline-flex items-center justify-center h-8 w-8 rounded-full bg-[#23272a]\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#e2001a\' viewBox=\'0 0 24 24\' style=\'height:16px;width:16px;\'><circle cx=\'12\' cy=\'12\' r=\'10\' fill=\'#23272a\'/><path d=\'M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z\' fill=\'#e2001a\'/><circle cx=\'12\' cy=\'12\' r=\'3\' fill=\'#fff\'/></svg></span>`}<span class='font-bold'>${e.nom}</span></div>`).join('') : "<div class='text-gray-500 p-2'>Aucune équipe trouvée</div>";
                }
                const equipeInput = document.getElementById('equipe_search');
                const equipeResults = document.getElementById('equipe_results');
                equipeInput.addEventListener('input', function() {
                    const val = this.value.toLowerCase();
                    const filtered = equipes.filter(e => e.nom.toLowerCase().includes(val));
                    equipeResults.innerHTML = renderEquipeResults(filtered);
                    equipeResults.style.display = filtered.length ? 'block' : 'none';
                });
                window.selectEquipe = function(id, nom) {
                    document.getElementById('equipe_id').value = id;
                    document.getElementById('equipe_search').value = nom;
                    equipeResults.innerHTML = '';
                    equipeResults.style.display = 'none';
                };
                // Fermer la liste si on clique ailleurs
                document.addEventListener('click', function(e) {
                    if (!equipeInput.contains(e.target) && !equipeResults.contains(e.target)) {
                        equipeResults.style.display = 'none';
                    }
                });
            </script>
            @endif
            <div class="flex gap-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary">← Retour</a>
            </div>
            <div class="mt-8">
                <h3 class="text-lg font-bold text-blue-700 dark:text-blue-300 mb-2">Historique des clubs</h3>
                @if($joueur->transferts->isEmpty())
                    <p class="text-gray-500 italic">Ce joueur n’a pas encore changé de club ou n’a pas d’historique de transfert.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($joueur->transferts->sortByDesc('date') as $transfert)
                            <li class="py-2 flex items-center gap-4">
                                <span class="text-gray-700 dark:text-gray-200">
                                    @php
                                        $date = $transfert->date ? \Carbon\Carbon::parse($transfert->date)->format('d/m/Y') : '';
                                        $from = $transfert->fromEquipe->nom ?? 'Libre';
                                        $to = $transfert->toEquipe->nom ?? 'Libre';
                                    @endphp
                                    @if($transfert->type === 'transfert')
                                        Le {{ $date }} : Transféré de <b>{{ $from }}</b> à <b>{{ $to }}</b>
                                    @elseif($transfert->type === 'affectation')
                                        Le {{ $date }} : Affecté à <b>{{ $to }}</b>
                                    @elseif($transfert->type === 'liberation')
                                        Le {{ $date }} : Libéré de <b>{{ $from }}</b>
                                    @else
                                        Le {{ $date }} : Mouvement de club
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
