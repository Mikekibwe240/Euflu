

<?php $__env->startSection('title', 'Détail de l\'équipe'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full bg-[#e2001a] py-10 px-4 flex flex-col items-center relative mb-8">
    <div class="text-3xl md:text-4xl font-extrabold text-white uppercase tracking-wider mb-2"><?php echo e($equipe->nom); ?></div>
    <div class="text-base text-white font-semibold uppercase mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.382V5a2 2 0 012-2h14a2 2 0 012 2v10.382a2 2 0 01-1.553 1.894L15 20" /></svg>
        <?php echo e($equipe->stade ?? 'Stade inconnu'); ?>

    </div>
    <div class="absolute right-8 top-8">
        <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $equipe,'size' => 120]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($equipe),'size' => 120]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5564dd85bf2706938f671f4ed6c78011)): ?>
<?php $attributes = $__attributesOriginal5564dd85bf2706938f671f4ed6c78011; ?>
<?php unset($__attributesOriginal5564dd85bf2706938f671f4ed6c78011); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5564dd85bf2706938f671f4ed6c78011)): ?>
<?php $component = $__componentOriginal5564dd85bf2706938f671f4ed6c78011; ?>
<?php unset($__componentOriginal5564dd85bf2706938f671f4ed6c78011); ?>
<?php endif; ?>
    </div>
</div>
<div class="max-w-6xl mx-auto px-4">
    <div class="flex flex-col md:flex-row gap-8 mb-8">
        <div class="flex-1">
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="bg-[#23272a] rounded-lg shadow p-6 flex-1 flex flex-col items-center">
                    <div class="text-2xl font-bold text-white mb-2"><?php echo e($stats->points ?? 0); ?></div>
                    <div class="text-gray-400">Points</div>
                </div>
                <div class="bg-[#23272a] rounded-lg shadow p-6 flex-1 flex flex-col items-center">
                    <div class="text-2xl font-bold text-white mb-2"><?php echo e($stats->victoires ?? 0); ?></div>
                    <div class="text-gray-400">Victoires</div>
                </div>
                <div class="bg-[#23272a] rounded-lg shadow p-6 flex-1 flex flex-col items-center">
                    <div class="text-2xl font-bold text-white mb-2"><?php echo e($stats->nuls ?? 0); ?></div>
                    <div class="text-gray-400">Nuls</div>
                </div>
                <div class="bg-[#23272a] rounded-lg shadow p-6 flex-1 flex flex-col items-center">
                    <div class="text-2xl font-bold text-white mb-2"><?php echo e($stats->defaites ?? 0); ?></div>
                    <div class="text-gray-400">Défaites</div>
                </div>
            </div>
            <div class="bg-[#23272a] rounded-lg shadow p-6 mb-6">
                <div class="flex items-center gap-4 mb-2">
                    <span class="text-lg font-bold text-white">Pool :</span>
                    <span class="text-[#6fcf97] font-extrabold uppercase"><?php echo e($equipe->pool->nom ?? '-'); ?></span>
                </div>
                <div class="flex items-center gap-4 mb-2">
                    <span class="text-lg font-bold text-white">Coach :</span>
                    <span class="text-white"><?php echo e($equipe->coach ?? '-'); ?></span>
                </div>
                <div class="flex items-center gap-4 mb-2">
                    <span class="text-lg font-bold text-white">Saison :</span>
                    <span class="text-white"><?php echo e($equipe->saison->nom ?? '-'); ?></span>
                </div>
                <div class="flex items-center gap-4 mb-2">
                    <span class="text-lg font-bold text-white">Classement :</span>
                    <span class="text-white"><?php echo e($position ?? '-'); ?></span>
                </div>
            </div>
        </div>
        <div class="flex-1 flex flex-col items-center">
            <div class="bg-[#23272a] rounded-lg shadow p-6 w-full flex flex-col items-center mb-6">
                <div class="text-lg font-bold text-white mb-2">Meilleur buteur</div>
                <?php
                    $meilleur = $equipe->joueurs->sortByDesc(fn($j) => $j->buts->count())->first();
                ?>
                <?php if($meilleur): ?>
                    <div class="flex items-center gap-3">
                        <?php if($meilleur->photo): ?>
                            <img src="<?php echo e(asset('storage/' . $meilleur->photo)); ?>" alt="Photo <?php echo e($meilleur->nom); ?>" class="h-12 w-12 rounded-full object-cover border border-gray-200 bg-white" onerror="this.style.display='none'">
                        <?php else: ?>
                            <span class="flex h-12 w-12 rounded-full bg-blue-100 text-blue-700 font-bold items-center justify-center text-xl"><?php echo e(strtoupper(substr($meilleur->nom,0,1))); ?></span>
                        <?php endif; ?>
                        <span class="font-semibold text-white text-lg"><?php echo e($meilleur->nom); ?> <?php echo e($meilleur->prenom); ?></span>
                        <span class="text-[#6fcf97] font-bold text-lg"><?php echo e($meilleur->buts->count()); ?> buts</span>
                    </div>
                <?php else: ?>
                    <span class="text-gray-400">Aucun buteur</span>
                <?php endif; ?>
            </div>
            <div class="bg-[#23272a] rounded-lg shadow p-6 w-full flex flex-col items-center">
                <div class="text-lg font-bold text-white mb-2">Nombre de joueurs</div>
                <span class="text-3xl font-extrabold text-[#6fcf97]"><?php echo e($equipe->joueurs->count()); ?></span>
            </div>
        </div>
    </div>
    <div class="mb-8">
        <div class="text-2xl font-bold text-white mb-4">Joueurs de l'équipe</div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $equipe->joueurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('public.joueurs.show', $joueur->id)); ?>" class="flex items-center gap-4 bg-[#181d1f] rounded-lg p-4 hover:bg-[#23272a] transition group border border-[#31363a]">
                    <?php if($joueur->photo): ?>
                        <img src="<?php echo e(asset('storage/' . $joueur->photo)); ?>" alt="Photo <?php echo e($joueur->nom); ?>" class="h-12 w-12 rounded-full object-cover border border-gray-200 bg-white" onerror="this.style.display='none'">
                    <?php else: ?>
                        <span class="flex h-12 w-12 rounded-full bg-blue-100 text-blue-700 font-bold items-center justify-center text-xl"><?php echo e(strtoupper(substr($joueur->nom,0,1))); ?></span>
                    <?php endif; ?>
                    <div>
                        <div class="font-bold text-white text-lg group-hover:text-[#6fcf97]"><?php echo e($joueur->nom); ?> <?php echo e($joueur->prenom); ?></div>
                        <div class="text-gray-400 text-sm"><?php echo e($joueur->poste); ?></div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <div class="mb-8">
        <div class="text-2xl font-bold text-white mb-4">Rencontres</div>
        <div class="overflow-x-auto rounded-lg shadow" style="background:#181d1f;">
            <table class="min-w-full bg-[#23272a] text-white text-base bundesliga-table" style="border-radius:0;">
                <thead class="bg-transparent text-white uppercase text-base">
                    <tr>
                        <th class="px-4 py-3 text-left font-extrabold">Date</th>
                        <th class="px-4 py-3 text-left font-extrabold">Adversaire</th>
                        <th class="px-4 py-3 text-center font-extrabold">Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $rencontres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-4 py-3"><?php echo e(\Carbon\Carbon::parse($match->date)->format('d/m/Y')); ?></td>
                            <td class="px-4 py-3"><?php echo e($match->equipe1_id == $equipe->id ? $match->equipe2->nom : $match->equipe1->nom); ?></td>
                            <td class="px-4 py-3 text-center">
                                <?php if($match->score_equipe1 !== null && $match->score_equipe2 !== null): ?>
                                    <?php echo e($match->equipe1_id == $equipe->id ? $match->score_equipe1 : $match->score_equipe2); ?> - <?php echo e($match->equipe1_id == $equipe->id ? $match->score_equipe2 : $match->score_equipe1); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mb-8">
        <div class="text-2xl font-bold text-white mb-4">Progression (points cumulés)</div>
        <canvas id="progressionChart" height="120"></canvas>
        <div class="mt-2 text-sm text-gray-400">Points cumulés : <span class="font-bold" id="points-cumules"></span></div>
    </div>
    <div class="mt-4 text-center">
        <a href="<?php echo e(route('public.equipes')); ?>" class="inline-block bg-[#23272a] text-white font-bold px-6 py-2 rounded-full shadow hover:bg-[#6fcf97] hover:text-[#23272a] transition-all duration-300 font-inter">← Retour aux clubs</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="/js/chart.umd.min.js"></script>
<?php if(!empty($rencontres) && !$rencontres->isEmpty()): ?>
<script>
    const rencontres = <?php echo json_encode($rencontres, 15, 512) ?>;
    const equipeId = <?php echo json_encode($equipe->id, 15, 512) ?>;
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
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/public/equipe_show.blade.php ENDPATH**/ ?>