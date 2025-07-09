

<?php $__env->startSection('title', 'Fiche Équipe'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-8">
    <div class="bg-bl-card rounded-lg shadow p-6 mb-8 flex flex-col md:flex-row items-center gap-8 border border-bl-border">
        <div class="flex-shrink-0
            <?php if($equipe->logo): ?>
                <span class="inline-flex items-center justify-center h-32 w-32 rounded-full bg-bl-card border border-bl-border overflow-hidden mb-4">
                    <img src="<?php echo e(asset('storage/' . $equipe->logo)); ?>" alt="Logo <?php echo e($equipe->nom); ?>" class="h-32 w-32 object-cover" onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'flex h-32 w-32 rounded-full bg-[#23272a] items-center justify-center\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#e2001a\' viewBox=\'0 0 24 24\' style=\'height:60px;width:60px;\'><circle cx=\'12\' cy=\'12\' r=\'10\' fill=\'#23272a\'/><path d=\'M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z\' fill=\'#e2001a\'/><circle cx=\'12\' cy=\'12\' r=\'3\' fill=\'#fff\'/></svg></span>'">
                </span>
            <?php else: ?>
                <div class="h-32 w-32 flex items-center justify-center rounded-full bg-[#23272a] mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#e2001a" viewBox="0 0 24 24" style="height:60px;width:60px;">
                        <circle cx="12" cy="12" r="10" fill="#23272a"/>
                        <path d="M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z" fill="#e2001a"/>
                        <circle cx="12" cy="12" r="3" fill="#fff"/>
                    </svg>
                </div>
            <?php endif; ?>
            <div class="text-lg font-semibold text-white"><?php echo e($equipe->nom); ?></div>
            <div class="text-gray-400">Poule : <?php echo e($equipe->pool->nom ?? '-'); ?></div>
            <div class="text-gray-400">Coach : <?php echo e($equipe->coach ?? '-'); ?></div>
            <div class="text-gray-400">Saison : <?php echo e($equipe->saison->nom ?? '-'); ?></div>
        </div>
        <div class="flex-1">
            <h2 class="text-2xl font-semibold text-white mb-4">Statistiques</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-bl-card border border-bl-border rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-white mb-2"><?php echo e($equipe->joueurs->sum(fn($j) => $j->buts->count())); ?></div>
                    <div class="text-lg text-white font-semibold">Buts marqués</div>
                </div>
                <div class="bg-bl-card border border-bl-border rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-green-400 mb-2"><?php echo e($equipe->joueurs->count()); ?></div>
                    <div class="text-lg text-green-400 font-semibold">Joueurs</div>
                </div>
            </div>
            
            
            <div class="mb-8">
                <h3 class="text-lg font-bold text-white mb-2">Marge de progression (par match)</h3>
                <?php if(empty($rencontres) || $rencontres->isEmpty()): ?>
                    <p class="text-gray-400 italic">Aucune rencontre enregistrée.</p>
                <?php else: ?>
                    <canvas id="progressionChart" height="120"></canvas>
                    <div class="mt-2 text-sm text-gray-200">Points cumulés : <span class="font-bold" id="points-cumules"></span></div>
                <?php endif; ?>
            </div>
            <h2 class="text-2xl font-semibold text-white mb-4">Joueurs de l'équipe</h2>
            <?php if($equipe->joueurs->isEmpty()): ?>
                <p class="text-gray-400">Aucun joueur enregistré pour cette équipe.</p>
            <?php else: ?>
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
                        <?php $__currentLoopData = $equipe->joueurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b border-bl-border text-center align-middle hover:bg-bl-dark transition cursor-pointer" onclick="window.location='<?php echo e(route('admin.joueurs.show', $joueur)); ?>'">
                            <td class="py-2 px-4">
                                <?php if($joueur->photo): ?>
                                    <img src="<?php echo e(asset('storage/' . $joueur->photo)); ?>" alt="Photo" class="h-10 w-10 rounded-full object-cover border border-bl-border bg-bl-card mx-auto" onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center mx-auto\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#b0b0b0\' viewBox=\'0 0 24 24\' class=\'h-8 w-8\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z\'/></svg></div>'">
                                <?php else: ?>
                                    <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center mx-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-8 w-8">
                                            <circle cx="12" cy="8" r="4"/>
                                            <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-2 px-4 font-semibold text-white"><?php echo e($joueur->nom); ?></td>
                            <td class="py-2 px-4 text-white"><?php echo e($joueur->prenom); ?></td>
                            <td class="py-2 px-4 text-white"><?php echo e($joueur->date_naissance); ?></td>
                            <td class="py-2 px-4 text-white"><?php echo e($joueur->poste); ?></td>
                            <td class="py-2 px-4 font-mono text-white"><?php echo e($joueur->numero_licence ?? '-'); ?></td>
                            <td class="py-2 px-4 font-mono text-white"><?php echo e($joueur->numero_dossard ?? '-'); ?></td>
                            <td class="py-2 px-4 text-white"><?php echo e($joueur->nationalite ?? '-'); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <div class="flex gap-4 mb-6">
        <a href="<?php echo e(route('admin.equipes.edit', $equipe)); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 transition">Modifier</a>
        <form action="<?php echo e(route('admin.equipes.destroy', $equipe)); ?>" method="POST" onsubmit="return confirm('Supprimer cette équipe ? Cette action est irréversible.');" class="inline">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition">Retirer</button>
        </form>
        <?php if(is_null($equipe->pool_id)): ?>
            <form action="<?php echo e(route('admin.equipes.affecterPool', $equipe)); ?>" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <select name="pool_id" required class="form-select rounded border-gray-300 dark:bg-gray-700 dark:text-white mr-2">
                    <option value="">Sélectionner un pool</option>
                    <?php $__currentLoopData = App\Models\Pool::where('saison_id', $equipe->saison_id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($pool->id); ?>"><?php echo e($pool->nom); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 border border-yellow-500 transition">Affecter dans un POOL</button>
            </form>
        <?php endif; ?>
        <?php if(!is_null($equipe->pool_id)): ?>
            <form action="<?php echo e(route('admin.equipes.retirerPool', $equipe)); ?>" method="POST" class="inline" onsubmit="return confirm('Retirer cette équipe du pool ?');">
                <?php echo csrf_field(); ?>
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition">Retirer du POOL <?php echo e($equipe->pool->nom); ?></button>
            </form>
        <?php endif; ?>
    </div>
    <div class="flex gap-4">
        <a href="<?php echo e(route('admin.equipes.index')); ?>" class="mb-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">← Retour à la liste</a>
    </div>
    <?php if(session('success')): ?>
        <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 shadow">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'error','message' => session('error')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'error','message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('error'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'error','message' => $errors->first()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'error','message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
    <?php endif; ?>
    <h2 class="text-2xl font-semibold text-white mb-4">Ajouter un joueur existant (libre)</h2>
    <form method="POST" action="<?php echo e(route('admin.equipes.ajouterJoueur', $equipe->id)); ?>" class="mb-6 flex flex-col gap-4 items-start">
        <?php echo csrf_field(); ?>
        <div class="w-full max-w-md">
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow p-2 divide-y divide-gray-200 dark:divide-gray-700">
                <?php
                    $joueursLibres = \App\Models\Joueur::whereNull('equipe_id')->orderBy('nom')->get();
                ?>
                <?php $__empty_1 = true; $__currentLoopData = $joueursLibres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <label class="flex items-center gap-3 py-2 px-2 cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900 rounded transition">
                        <input type="radio" name="joueur_id" value="<?php echo e($joueur->id); ?>" class="form-radio text-blue-600" required>
                        <?php if($joueur->photo): ?>
                            <img src="<?php echo e(asset('storage/' . $joueur->photo)); ?>" alt="Photo <?php echo e($joueur->nom); ?>" class="h-10 w-10 rounded-full object-cover border border-gray-200 dark:border-gray-700 bg-white" onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center mx-auto\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#b0b0b0\' viewBox=\'0 0 24 24\' class=\'h-8 w-8\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z\'/></svg></div>'">
                        <?php else: ?>
                            <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-8 w-8">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                        <span class="font-medium text-gray-800 dark:text-gray-100"><?php echo e($joueur->nom); ?> <?php echo e($joueur->prenom); ?></span>
                        <span class="text-gray-500 text-sm"><?php echo e($joueur->poste); ?></span>
                    </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-gray-500 italic py-2 px-2">Aucun joueur libre disponible</div>
                <?php endif; ?>
            </div>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Ajouter</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php
    $hasRencontres = isset($rencontres) && !empty($rencontres) && !$rencontres->isEmpty();
    $rencontresJson = $hasRencontres ? $rencontres->toJson() : '[]';
    $equipeId = $equipe->id;
?>

<?php $__env->startPush('scripts'); ?>
<script src="/js/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const hasRencontres = <?php echo $hasRencontres ? 'true' : 'false'; ?>;
    const rencontres = <?php echo $rencontresJson; ?>;
    const equipeId = <?php echo e($equipeId); ?>;
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/equipes/show.blade.php ENDPATH**/ ?>