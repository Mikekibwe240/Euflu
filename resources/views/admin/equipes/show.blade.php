@extends('layouts.admin')

@section('title', 'Fiche Équipe')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-bl-card rounded-lg shadow p-6 mb-8 flex flex-col md:flex-row items-center gap-8 border border-bl-border">
        <div class="flex-shrink-0
            @if($equipe->logo)
                <span class="inline-flex items-center justify-center h-32 w-32 rounded-full bg-bl-card border border-bl-border overflow-hidden mb-4">
                    <img src="{{ asset('storage/' . $equipe->logo) }}" alt="Logo {{ $equipe->nom }}" class="h-32 w-32 object-cover" onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'flex h-32 w-32 rounded-full bg-[#23272a] items-center justify-center\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#e2001a\' viewBox=\'0 0 24 24\' style=\'height:60px;width:60px;\'><circle cx=\'12\' cy=\'12\' r=\'10\' fill=\'#23272a\'/><path d=\'M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z\' fill=\'#e2001a\'/><circle cx=\'12\' cy=\'12\' r=\'3\' fill=\'#fff\'/></svg></span>'">
                </span>
            @else
                <div class="h-32 w-32 flex items-center justify-center rounded-full bg-[#23272a] mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#e2001a" viewBox="0 0 24 24" style="height:60px;width:60px;">
                        <circle cx="12" cy="12" r="10" fill="#23272a"/>
                        <path d="M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z" fill="#e2001a"/>
                        <circle cx="12" cy="12" r="3" fill="#fff"/>
                    </svg>
                </div>
            @endif
            <div class="text-lg font-semibold text-white">{{ $equipe->nom }}</div>
            <div class="text-gray-400">Poule : {{ $equipe->pool->nom ?? '-' }}</div>
            <div class="text-gray-400">Coach : {{ $equipe->coach ?? '-' }}</div>
            <div class="text-gray-400">Saison : {{ $equipe->saison->nom ?? '-' }}</div>
        </div>
        <div class="flex-1">
            <h2 class="text-2xl font-semibold text-white mb-4">Statistiques</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-bl-card border border-bl-border rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-white mb-2">{{ $equipe->joueurs->sum(fn($j) => $j->buts->count()) }}</div>
                    <div class="text-lg text-white font-semibold">Buts marqués</div>
                </div>
                <div class="bg-bl-card border border-bl-border rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-green-400 mb-2">{{ $equipe->joueurs->count() }}</div>
                    <div class="text-lg text-green-400 font-semibold">Joueurs</div>
                </div>
            </div>
            {{-- Suppression du bloc 'Marge de progression (par saison)' --}}
            {{-- Marge de progression (par match) en graphique --}}
            <div class="mb-8">
                <h3 class="text-lg font-bold text-white mb-2">Marge de progression (par match)</h3>
                @if(empty($rencontres) || $rencontres->isEmpty())
                    <p class="text-gray-400 italic">Aucune rencontre enregistrée.</p>
                @else
                    <canvas id="progressionChart" height="120"></canvas>
                    <div class="mt-2 text-sm text-gray-200">Points cumulés : <span class="font-bold" id="points-cumules"></span></div>
                @endif
            </div>
            <h2 class="text-2xl font-semibold text-white mb-4">Joueurs de l'équipe</h2>
            @if($equipe->joueurs->isEmpty())
                <p class="text-gray-400">Aucun joueur enregistré pour cette équipe.</p>
            @else
                <table class="min-w-full bg-bl-card border border-bl-border rounded-lg shadow mt-4 table-fixed">
                    <thead class="bg-[#23272a]">
                        <tr>
                            <th class="py-2 px-4 w-20 text-center text-white">Photo</th>
                            <th class="py-2 px-4 w-32 text-center text-white">Nom</th>
                            <th class="py-2 px-4 w-32 text-center text-white">Prénom</th>
                            <th class="py-2 px-4 w-32 text-center text-white">Date naissance</th>
                            <th class="py-2 px-4 w-24 text-center text-white">Poste</th>
                            <th class="py-2 px-4 w-28 text-center text-white">Licence</th>
                            <th class="py-2 px-4 w-20 text-center text-white">Dossard</th>
                            <th class="py-2 px-4 w-28 text-center text-white">Nationalité</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipe->joueurs as $joueur)
                        <tr class="border-b border-bl-border text-center align-middle hover:bg-bl-dark transition cursor-pointer" onclick="window.location='{{ route('admin.joueurs.show', $joueur) }}'">
                            <td class="py-2 px-4">
                                @if($joueur->photo)
                                    <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo" class="h-10 w-10 rounded-full object-cover border border-bl-border bg-bl-card mx-auto" onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center mx-auto\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#b0b0b0\' viewBox=\'0 0 24 24\' class=\'h-8 w-8\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z\'/></svg></div>'">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center mx-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-8 w-8">
                                            <circle cx="12" cy="8" r="4"/>
                                            <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="py-2 px-4 font-semibold text-white">{{ $joueur->nom }}</td>
                            <td class="py-2 px-4 text-white">{{ $joueur->prenom }}</td>
                            <td class="py-2 px-4 text-white">{{ $joueur->date_naissance }}</td>
                            <td class="py-2 px-4 text-white">{{ $joueur->poste }}</td>
                            <td class="py-2 px-4 font-mono text-white">{{ $joueur->numero_licence ?? '-' }}</td>
                            <td class="py-2 px-4 font-mono text-white">{{ $joueur->numero_dossard ?? '-' }}</td>
                            <td class="py-2 px-4 text-white">{{ $joueur->nationalite ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <div class="flex gap-4 mb-6">
        <a href="{{ route('admin.equipes.edit', $equipe) }}" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 transition">Modifier</a>
        <form action="{{ route('admin.equipes.destroy', $equipe) }}" method="POST" onsubmit="return confirm('Supprimer cette équipe ? Cette action est irréversible.');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition">Retirer</button>
        </form>
        @if(is_null($equipe->pool_id))
            <form action="{{ route('admin.equipes.affecterPool', $equipe) }}" method="POST" class="inline">
                @csrf
                <select name="pool_id" required class="form-select rounded border-gray-300 dark:bg-gray-700 dark:text-white mr-2">
                    <option value="">Sélectionner un pool</option>
                    @foreach(App\Models\Pool::where('saison_id', $equipe->saison_id)->get() as $pool)
                        <option value="{{ $pool->id }}">{{ $pool->nom }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 border border-yellow-500 transition">Affecter dans un POOL</button>
            </form>
        @endif
        @if(!is_null($equipe->pool_id))
            <form action="{{ route('admin.equipes.retirerPool', $equipe) }}" method="POST" class="inline" onsubmit="return confirm('Retirer cette équipe du pool ?');">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition">Retirer du POOL {{ $equipe->pool->nom }}</button>
            </form>
        @endif
    </div>
    <div class="flex gap-4">
        <a href="{{ route('admin.equipes.index') }}" class="mb-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">← Retour à la liste</a>
    </div>
    @if(session('success'))
        <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 shadow">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif
    <h2 class="text-2xl font-semibold text-white mb-4">Ajouter un joueur existant (libre)</h2>
    <form method="POST" action="{{ route('admin.equipes.ajouterJoueur', $equipe->id) }}" class="mb-6 flex flex-col gap-4 items-start">
        @csrf
        <div class="w-full max-w-md">
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow p-2 divide-y divide-gray-200 dark:divide-gray-700">
                @php
                    $joueursLibres = \App\Models\Joueur::whereNull('equipe_id')->orderBy('nom')->get();
                @endphp
                @forelse($joueursLibres as $joueur)
                    <label class="flex items-center gap-3 py-2 px-2 cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900 rounded transition">
                        <input type="radio" name="joueur_id" value="{{ $joueur->id }}" class="form-radio text-blue-600" required>
                        @if($joueur->photo)
                            <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo {{ $joueur->nom }}" class="h-10 w-10 rounded-full object-cover border border-gray-200 dark:border-gray-700 bg-white" onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center mx-auto\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#b0b0b0\' viewBox=\'0 0 24 24\' class=\'h-8 w-8\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z\'/></svg></div>'">
                        @else
                            <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-8 w-8">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                                </svg>
                            </div>
                        @endif
                        <span class="font-medium text-gray-800 dark:text-gray-100">{{ $joueur->nom }} {{ $joueur->prenom }}</span>
                        <span class="text-gray-500 text-sm">{{ $joueur->poste }}</span>
                    </label>
                @empty
                    <div class="text-gray-500 italic py-2 px-2">Aucun joueur libre disponible</div>
                @endforelse
            </div>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Ajouter</button>
    </form>
</div>
@endsection

@php
    $hasRencontres = isset($rencontres) && !empty($rencontres) && !$rencontres->isEmpty();
    $rencontresJson = $hasRencontres ? $rencontres->toJson() : '[]';
    $equipeId = $equipe->id;
@endphp

@push('scripts')
<script src="/js/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const hasRencontres = {!! $hasRencontres ? 'true' : 'false' !!};
    const rencontres = {!! $rencontresJson !!};
    const equipeId = {{ $equipeId }};
    const ctx = document.getElementById('progressionChart').getContext('2d');
    if (hasRencontres && rencontres.length > 0) {
        let labels = [];
        let points = [];
        let total = 0;
        rencontres.forEach(match => {
            let isHome = match.equipe1_id == equipeId;
            let score1 = match.score_equipe1;
            let score2 = match.score_equipe2;
            let label = match.date + ' vs ' + (isHome ? (match.equipe2?.nom || '-') : (match.equipe1?.nom || '-'));
            labels.push(label);
            if(score1 !== null && score2 !== null) {
                if((isHome && score1 > score2) || (!isHome && score2 > score1)) total += 3;
                else if(score1 == score2) total += 1;
            }
            points.push(total);
        });
        document.getElementById('points-cumules').textContent = total;
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Points cumulés',
                    data: points,
                    fill: true,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.1)',
                    tension: 0.3,
                    pointBackgroundColor: '#2563eb',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                },
                scales: {
                    x: { title: { display: true, text: 'Match' } },
                    y: { title: { display: true, text: 'Points cumulés' }, beginAtZero: true, precision:0 }
                }
            }
        });
    } else {
        // Affiche un graphique vide pour garder l'harmonie visuelle
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Aucune donnée'],
                datasets: [{
                    label: 'Points cumulés',
                    data: [0],
                    fill: true,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.1)',
                    tension: 0.3,
                    pointBackgroundColor: '#2563eb',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                },
                scales: {
                    x: { title: { display: true, text: 'Match' } },
                    y: { title: { display: true, text: 'Points cumulés' }, beginAtZero: true, precision:0 }
                }
            }
        });
    }
});
</script>
@endpush
