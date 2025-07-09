<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
    <div class="bg-bl-card rounded-lg shadow p-6 min-h-[320px] flex flex-col justify-between">
        <h3 class="text-lg font-bold mb-4 text-white">Évolution du nombre de joueurs et équipes</h3>
        <canvas id="chart-joueurs-equipes" class="w-full h-64"></canvas>
        <div id="no-joueurs-equipes-data" class="text-center text-gray-400 mt-8">
            @if(count($evolutionLabels) <= 1)
                Données actuelles : pas assez de matchs joués pour une évolution.
            @else
                Évolution réelle par rapport aux matchs joués.
            @endif
        </div>
    </div>
    <div class="bg-bl-card rounded-lg shadow p-6 min-h-[320px] flex flex-col justify-between">
        <h3 class="text-lg font-bold mb-4 text-white">Répartition des buts et cartons</h3>
        <canvas id="chart-buts-cartons" class="w-full h-64"></canvas>
        <div id="no-buts-cartons-data" class="text-center text-gray-400 mt-8">Données fictives : total actuel.</div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const evolutionLabels = @json($evolutionLabels);
const evolutionJoueurs = @json($evolutionJoueurs);
const evolutionEquipes = @json($evolutionEquipes);
const joueursEquipesCtx = document.getElementById('chart-joueurs-equipes').getContext('2d');
new Chart(joueursEquipesCtx, {
    type: 'line',
    data: {
        labels: evolutionLabels,
        datasets: [
            {
                label: 'Joueurs',
                data: evolutionJoueurs,
                borderColor: 'rgb(234,179,8)',
                backgroundColor: 'rgba(234,179,8,0.2)',
                tension: 0.3
            },
            {
                label: 'Équipes',
                data: evolutionEquipes,
                borderColor: 'rgb(34,197,94)',
                backgroundColor: 'rgba(34,197,94,0.2)',
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            title: { display: false }
        }
    }
});
// Graphique buts/cartons (données fictives si pas de stats)
const buts = {{ $buts ?? 42 }};
const cartons = {{ $cartons ?? 12 }};
const butsCartonsCtx = document.getElementById('chart-buts-cartons').getContext('2d');
new Chart(butsCartonsCtx, {
    type: 'doughnut',
    data: {
        labels: ['Buts', 'Cartons'],
        datasets: [{
            data: [buts, cartons],
            backgroundColor: ['#ef4444', '#f59e42'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            title: { display: false }
        }
    }
});
</script>
@endpush
