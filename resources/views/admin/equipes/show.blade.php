@extends('layouts.admin')

@section('title', 'Fiche Équipe')

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mb-8 flex flex-col md:flex-row items-center gap-8">
        <div class="flex-shrink-0
            @if($equipe->logo)
                <span class="inline-flex items-center justify-center h-32 w-32 rounded-full bg-white border border-blue-200 dark:border-blue-700 overflow-hidden mb-4">
                    <img src="{{ asset('storage/' . $equipe->logo) }}" alt="Logo {{ $equipe->nom }}" class="h-32 w-32 object-cover" onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'flex h-32 w-32 rounded-full bg-blue-100 text-blue-700 font-bold items-center justify-center\'>{{ strtoupper(substr($equipe->nom,0,2)) }}</span>'">
                </span>
            @else
                <div class="h-32 w-32 flex items-center justify-center rounded-full bg-blue-100 text-blue-700 font-bold text-4xl mb-4">{{ strtoupper(substr($equipe->nom,0,2)) }}</div>
            @endif
            <div class="text-lg font-semibold text-blue-800 dark:text-blue-200">{{ $equipe->nom }}</div>
            <div class="text-gray-500 dark:text-gray-300">Poule : {{ $equipe->pool->nom ?? '-' }}</div>
            <div class="text-gray-500 dark:text-gray-300">Coach : {{ $equipe->coach ?? '-' }}</div>
            <div class="text-gray-500 dark:text-gray-300">Saison : {{ $equipe->saison->nom ?? '-' }}</div>
        </div>
        <div class="flex-1">
            <h2 class="text-2xl font-semibold text-blue-700 dark:text-blue-300 mb-4">Statistiques</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-100 to-blue-300 dark:from-blue-900 dark:to-blue-700 rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-blue-800 dark:text-blue-200 mb-2">{{ $equipe->joueurs->sum(fn($j) => $j->buts->count()) }}</div>
                    <div class="text-lg text-blue-700 dark:text-blue-300 font-semibold">Buts marqués</div>
                </div>
                <div class="bg-gradient-to-br from-green-100 to-green-300 dark:from-green-900 dark:to-green-700 rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-green-800 dark:text-green-200 mb-2">{{ $equipe->joueurs->count() }}</div>
                    <div class="text-lg text-green-700 dark:text-green-300 font-semibold">Joueurs</div>
                </div>
            </div>
            {{-- Suppression du bloc 'Marge de progression (par saison)' --}}
            {{-- Marge de progression (par match) en graphique --}}
            <div class="mb-8">
                <h3 class="text-lg font-bold text-blue-700 dark:text-blue-300 mb-2">Marge de progression (par match)</h3>
                @if(empty($rencontres) || $rencontres->isEmpty())
                    <p class="text-gray-500 italic">Aucune rencontre enregistrée.</p>
                @else
                    <canvas id="progressionChart" height="120"></canvas>
                    <div class="mt-2 text-sm text-gray-700 dark:text-gray-200">Points cumulés : <span class="font-bold" id="points-cumules"></span></div>
                @endif
            </div>
            <h2 class="text-2xl font-semibold text-blue-700 dark:text-blue-300 mb-4">Joueurs de l'équipe</h2>
            @if($equipe->joueurs->isEmpty())
                <p class="text-gray-500">Aucun joueur enregistré pour cette équipe.</p>
            @else
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($equipe->joueurs as $joueur)
                        <li class="py-3 flex items-center gap-4 hover:bg-blue-50 dark:hover:bg-blue-900 transition cursor-pointer rounded"
                            onclick="window.location='{{ route('admin.joueurs.show', $joueur->id) }}'">
                            @if($joueur->photo)
                                <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo {{ $joueur->nom }}" class="h-10 w-10 rounded-full object-cover border border-gray-200 dark:border-gray-700 bg-white" onerror="this.style.display='none'">
                            @else
                                <span class="flex h-10 w-10 rounded-full bg-blue-100 text-blue-700 font-bold items-center justify-center">{{ strtoupper(substr($joueur->nom,0,1)) }}</span>
                            @endif
                            <span class="font-medium text-lg text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded transition-colors duration-200">
                                {{ $joueur->nom }} {{ $joueur->prenom }}
                            </span>
                            <span class="text-gray-500 ml-auto">{{ $joueur->poste }}</span>
                        </li>
                    @endforeach
                </ul>
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
        {{-- Suppression du bouton Ajouter un joueur --}}
    </div>
    <div class="flex gap-4">
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary">← Retour</a>
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
    <h2 class="text-2xl font-semibold text-blue-700 dark:text-blue-300 mb-4">Ajouter un joueur existant (libre)</h2>
    <form method="POST" action="{{ route('admin.equipes.ajouterJoueur', $equipe->id) }}" class="mb-6 flex gap-4 items-end">
        @csrf
        <select name="joueur_id" class="form-select w-64 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
            <option value="">Sélectionner un joueur libre</option>
            @foreach(\App\Models\Joueur::whereNull('equipe_id')->orderBy('nom')->get() as $joueur)
                <option value="{{ $joueur->id }}">{{ $joueur->nom }} {{ $joueur->prenom }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Ajouter</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="/js/chart.umd.min.js"></script>
<script>
@if(!empty($rencontres) && !$rencontres->isEmpty())
    const rencontres = @json($rencontres);
    const equipeId = @json($equipe->id);
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
    new Chart(document.getElementById('progressionChart').getContext('2d'), {
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
@endif
</script>
@endsection
