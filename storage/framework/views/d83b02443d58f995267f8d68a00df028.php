

<?php $__env->startSection('title', "CLASSEMENTS D'EQUIPES"); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-8 text-center text-white">CLASSEMENTS D'EQUIPES</h1>
    <div class="mb-4 text-center text-lg font-semibold text-white">
        Saison active :
        <span class="font-bold"><?php echo e($selectedSaison?->nom ?? $selectedSaison?->annee ?? 'Aucune'); ?></span>
    </div>
    <form method="GET" action="" class="mb-6 flex flex-wrap gap-2 items-center justify-center bg-bl-card p-4 rounded-lg shadow border border-bl-border">
        <label for="saison_id" class="font-semibold text-gray-200">Filtrer par saison :</label>
        <select name="saison_id" id="saison_id" class="border border-bl-border rounded px-2 py-1 bg-gray-800 text-white" onchange="this.form.submit()">
            <option value="">Actuelle</option>
            <?php $__currentLoopData = $saisons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s->id); ?>" <?php if(request('saison_id', $selectedSaison?->id) == $s->id): ?> selected <?php endif; ?>><?php echo e($s->nom ?? $s->annee); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <label for="pool" class="font-semibold ml-4 text-gray-200">Filtrer par pool :</label>
        <select name="pool" id="pool" class="border border-bl-border rounded px-2 py-1 bg-gray-800 text-white" onchange="this.form.submit()">
            <option value="">Tous les pools</option>
            <?php $__currentLoopData = $pools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p->nom); ?>" <?php if(request('pool', $selectedPool) == $p->nom): ?> selected <?php endif; ?>>Pool <?php echo e($p->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </form>
    <div class="space-y-12">
        <?php $__currentLoopData = $pools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                // Afficher toutes les équipes du pool même sans stats
                $classement = $pool->equipes->map(function($eq) use ($selectedSaison) {
                    $stats = $eq->statsSaison($selectedSaison?->id)->first();
                    return (object) [
                        'equipe' => $eq,
                        'mj' => ($stats?->victoires ?? 0) + ($stats?->nuls ?? 0) + ($stats?->defaites ?? 0),
                        'mg' => $stats?->victoires ?? 0,
                        'mp' => $stats?->defaites ?? 0,
                        'mn' => $stats?->nuls ?? 0,
                        'bp' => $stats?->buts_pour ?? 0,
                        'bc' => $stats?->buts_contre ?? 0,
                        'gd' => ($stats?->buts_pour ?? 0) - ($stats?->buts_contre ?? 0),
                        'points' => $stats?->points ?? 0,
                        'qualifie' => $stats?->qualifie ?? false,
                        'relegue' => $stats?->relegue ?? false,
                    ];
                })->sortByDesc('points')->sortByDesc('gd')->sortByDesc('bp')->values();
            ?>
            <div class="bg-bl-card border border-bl-border rounded-xl shadow-lg p-6 mb-8">
                <div class="flex flex-wrap gap-4 mb-4 items-center justify-between">
                    <h2 class="text-2xl font-bold text-white">Pool <?php echo e($pool->nom); ?></h2>
                    <div class="flex flex-wrap gap-2">
                        <div class="bg-green-900 text-green-400 px-4 py-2 rounded-xl flex flex-col items-center min-w-[90px] border border-green-700">
                            <span class="font-bold text-lg"><?php echo e($classement->where('qualifie', true)->count()); ?></span>
                            <span class="text-xs font-semibold">Qualifiés</span>
                        </div>
                        <div class="bg-red-900 text-white px-4 py-2 rounded-xl flex flex-col items-center min-w-[90px] border border-red-700">
                            <span class="font-bold text-lg"><?php echo e($classement->where('relegue', true)->count()); ?></span>
                            <span class="text-xs font-semibold">Relégués</span>
                        </div>
                        <div class="bg-bl-card text-white px-4 py-2 rounded-xl flex flex-col items-center min-w-[90px] border border-bl-border">
                            <span class="font-bold text-lg"><?php echo e($classement->count()); ?></span>
                            <span class="text-xs font-semibold">Équipes</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-700 text-gray-200 text-xs font-semibold border border-bl-border">
                            Journées&nbsp;: <span class="ml-1 font-bold"><?php echo e($classement->max('journee') ?? '-'); ?></span>
                        </span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mb-4">
                    <div class="bg-bl-card border border-bl-border rounded-lg px-4 py-2 flex flex-col items-center min-w-[120px]">
                        <span class="font-bold text-lg text-white">Total buts</span>
                        <span class="text-xl font-bold"><?php echo e($classement->sum('bp')); ?></span>
                    </div>
                    <div class="bg-bl-card border border-bl-border rounded-lg px-4 py-2 flex flex-col items-center min-w-[120px]">
                        <span class="font-bold text-lg text-green-400">Total matchs</span>
                        <span class="text-xl font-bold"><?php echo e($classement->sum('mj')); ?></span>
                    </div>
                    <div class="bg-bl-card border border-bl-border rounded-lg px-4 py-2 flex flex-col items-center min-w-[120px]">
                        <span class="font-bold text-lg text-yellow-400">Ratio buts/match</span>
                        <span class="text-xl font-bold"><?php echo e($classement->sum('mj') ? number_format($classement->sum('bp') / $classement->sum('mj'), 2) : '-'); ?></span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mb-4">
                    <a href="<?php echo e(route('admin.classement_buteurs', ['pool' => $pool->id])); ?>" class="bg-bl-accent text-white px-4 py-2 rounded shadow hover:bg-bl-dark hover:text-bl-accent border border-bl-accent transition">TOPS BUTEURS</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-bl-card text-white rounded-2xl shadow-lg text-center border border-bl-border">
                        <thead class="bg-[#23272a]">
                            <tr>
                                <th class="px-2 py-2 rounded-tl-2xl text-white">PL</th>
                                <th class="px-2 py-2 text-white">EQUIPES</th>
                                <th class="px-2 py-2 text-white">MJ</th>
                                <th class="px-2 py-2 text-white">MG</th>
                                <th class="px-2 py-2 text-white">MP</th>
                                <th class="px-2 py-2 text-white">MN</th>
                                <th class="px-2 py-2 text-white">BP</th>
                                <th class="px-2 py-2 text-white">BC</th>
                                <th class="px-2 py-2 text-white">GD</th>
                                <th class="px-2 py-2 text-white">PTS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $classement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-bl-border hover:bg-bl-dark transition cursor-pointer" onclick="window.location='<?php echo e(route('admin.equipes.show', $item->equipe->id)); ?>'">
                                    <td class="px-2 py-2 font-bold text-white"><?php echo e($index+1); ?></td>
                                    <td class="px-2 py-2 font-semibold text-white flex items-center gap-2">
                                        <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $item->equipe,'size' => 28]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->equipe),'size' => 28]); ?>
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
                                        <span><?php echo e($item->equipe->nom ?? '-'); ?></span>
                                    </td>
                                    <td class="px-2 py-2 text-white"><?php echo e($item->mj); ?></td>
                                    <td class="px-2 py-2 text-white"><?php echo e($item->mg); ?></td>
                                    <td class="px-2 py-2 text-white"><?php echo e($item->mp); ?></td>
                                    <td class="px-2 py-2 text-white"><?php echo e($item->mn); ?></td>
                                    <td class="px-2 py-2 text-white"><?php echo e($item->bp); ?></td>
                                    <td class="px-2 py-2 text-white"><?php echo e($item->bc); ?></td>
                                    <td class="px-2 py-2 text-white"><?php echo e($item->gd); ?></td>
                                    <td class="px-2 py-2 font-bold text-white"><?php echo e($item->points); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/classement.blade.php ENDPATH**/ ?>