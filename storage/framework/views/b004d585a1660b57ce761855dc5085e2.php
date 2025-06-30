<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 min-h-[320px] flex flex-col justify-between">
        <h3 class="text-lg font-bold mb-4 text-blue-700 dark:text-blue-300">Évolution du nombre de joueurs et équipes</h3>
        <canvas id="chart-joueurs-equipes" class="w-full h-64"></canvas>
        <div id="no-joueurs-equipes-data" class="text-center text-gray-400 mt-8">
            <?php if(count($evolutionLabels) <= 1): ?>
                Données actuelles : pas assez de matchs joués pour une évolution.
            <?php else: ?>
                Évolution réelle par rapport aux matchs joués.
            <?php endif; ?>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 min-h-[320px] flex flex-col justify-between">
        <h3 class="text-lg font-bold mb-4 text-indigo-700 dark:text-indigo-300">Répartition des buts et cartons</h3>
        <canvas id="chart-buts-cartons" class="w-full h-64"></canvas>
        <div id="no-buts-cartons-data" class="text-center text-gray-400 mt-8">Données fictives : total actuel.</div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const evolutionLabels = <?php echo json_encode($evolutionLabels, 15, 512) ?>;
const evolutionJoueurs = <?php echo json_encode($evolutionJoueurs, 15, 512) ?>;
const evolutionEquipes = <?php echo json_encode($evolutionEquipes, 15, 512) ?>;
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
const buts = <?php echo e($buts ?? 42); ?>;
const cartons = <?php echo e($cartons ?? 12); ?>;
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
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/dashboard_graphs.blade.php ENDPATH**/ ?>