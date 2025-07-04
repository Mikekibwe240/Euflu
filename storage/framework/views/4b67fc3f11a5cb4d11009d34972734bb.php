

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Liste des rencontres <?php if($saison): ?> (Saison <?php echo e($saison->annee ?? ''); ?>) <?php endif; ?></h2>
    <div class="flex flex-wrap gap-4 mb-4">
        <a href="<?php echo e(route('admin.rencontres.create')); ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Ajouter une rencontre</a>
        <a href="/admin/matchs/generer" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Générer calendrier</a>
        <a href="<?php echo e(route('admin.rencontres.export', request()->all())); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">Exporter Excel</a>
        <a href="<?php echo e(route('admin.rencontres.exportPdf', request()->all())); ?>" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Exporter PDF</a>
    </div>
    <?php if(session('success')): ?>
        <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'success','message' => session('success')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success','message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('success'))]); ?>
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

    <form method="GET" action="<?php echo e(route('admin.rencontres.index')); ?>" class="mb-4 flex flex-wrap gap-4 items-end bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Pool</label>
            <select name="pool_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                <option value="">Tous</option>
                <?php if(isset($pools)): ?>
                    <?php $__currentLoopData = $pools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($pool->id); ?>" <?php echo e(request('pool_id') == $pool->id ? 'selected' : ''); ?>><?php echo e($pool->nom); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Équipe</label>
            <select name="equipe_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                <option value="">Toutes</option>
                <?php if(isset($equipes)): ?>
                    <?php $__currentLoopData = $equipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($equipe->id); ?>" <?php echo e(request('equipe_id') == $equipe->id ? 'selected' : ''); ?>><?php echo e($equipe->nom); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Saison</label>
            <select name="saison_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                <option value="">Actuelle</option>
                <?php if(isset($saisons)): ?>
                    <?php $__currentLoopData = $saisons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s->id); ?>" <?php echo e(request('saison_id') == $s->id ? 'selected' : ''); ?>><?php echo e($s->annee ?? $s->nom); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Journée</label>
            <input type="number" name="journee" value="<?php echo e(request('journee')); ?>" class="form-input w-24 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
        </div>
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Type de rencontre</label>
            <select name="type_rencontre" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                <option value="">Tous</option>
                <option value="championnat" <?php echo e(request('type_rencontre') == 'championnat' ? 'selected' : ''); ?>>Championnat</option>
                <option value="amical" <?php echo e(request('type_rencontre') == 'amical' ? 'selected' : ''); ?>>Amical</option>
                <option value="externe" <?php echo e(request('type_rencontre') == 'externe' ? 'selected' : ''); ?>>Externe</option>
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-700 dark:text-gray-200">État du match</label>
            <select name="etat_match" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
                <option value="">Tous</option>
                <option value="joue" <?php echo e(request('etat_match') == 'joue' ? 'selected' : ''); ?>>Match joué</option>
                <option value="non_joue" <?php echo e(request('etat_match') == 'non_joue' ? 'selected' : ''); ?>>Match non joué</option>
            </select>
        </div>
        <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-900 transition">Rechercher</button>
    </form>

    <div class="mb-4 flex flex-wrap gap-4 items-end">
        <input type="text" id="search-rencontres" placeholder="Recherche rapide..." class="form-input w-64 rounded border-gray-300 dark:bg-gray-700 dark:text-white" />
    </div>

    <?php
        // Regrouper les rencontres par journée
        $rencontresParJournee = $rencontres->getCollection()->groupBy('journee');
    ?>
    <div id="rencontres-tables">
    <?php $__currentLoopData = $rencontresParJournee; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journee => $liste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $titreJournee = $journee ? "Journée $journee" : 'Hors journées / Autres rencontres';
        ?>
        <h3 class="text-lg font-semibold mt-6 mb-2"><?php echo e($titreJournee); ?></h3>
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
                    <?php $__currentLoopData = $liste; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rencontre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-t text-center align-middle hover:bg-blue-50 dark:hover:bg-blue-900 cursor-pointer" onclick="window.location='<?php echo e(route('admin.rencontres.show', $rencontre)); ?>'">
                            <td class="px-4 py-2"><?php echo e($rencontre->date); ?></td>
                            <td class="px-4 py-2"><?php echo e($rencontre->heure); ?></td>
                            <td class="px-4 py-2"><?php echo e($rencontre->pool->nom ?? '-'); ?></td>
                            <td class="px-4 py-2 font-semibold">
                                <div class="flex items-center gap-2 justify-center min-h-[32px]">
                                    <?php if($rencontre->equipe1): ?>
                                        <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $rencontre->equipe1,'size' => '32']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rencontre->equipe1),'size' => '32']); ?>
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
                                    <?php elseif($rencontre->equipe1_libre): ?>
                                        <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => (object)['nom'=>$rencontre->equipe1_libre],'size' => '32']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((object)['nom'=>$rencontre->equipe1_libre]),'size' => '32']); ?>
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
                                    <?php else: ?>
                                        <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => null,'size' => '32']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'size' => '32']); ?>
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
                                    <?php endif; ?>
                                    <span class="truncate max-w-[120px] align-middle text-sm font-semibold"><?php echo e($rencontre->equipe1->nom ?? $rencontre->equipe1_libre ?? '-'); ?></span>
                                </div>
                            </td>
                            <td class="px-2 py-2 font-bold text-lg">vs</td>
                            <td class="px-4 py-2 font-semibold">
                                <div class="flex items-center gap-2 justify-center min-h-[32px]">
                                    <?php if($rencontre->equipe2): ?>
                                        <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $rencontre->equipe2,'size' => '32']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rencontre->equipe2),'size' => '32']); ?>
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
                                    <?php elseif($rencontre->equipe2_libre): ?>
                                        <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => (object)['nom'=>$rencontre->equipe2_libre],'size' => '32']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((object)['nom'=>$rencontre->equipe2_libre]),'size' => '32']); ?>
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
                                    <?php else: ?>
                                        <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => null,'size' => '32']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'size' => '32']); ?>
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
                                    <?php endif; ?>
                                    <span class="truncate max-w-[120px] align-middle text-sm font-semibold"><?php echo e($rencontre->equipe2->nom ?? $rencontre->equipe2_libre ?? '-'); ?></span>
                                </div>
                            </td>
                            <td class="px-4 py-2"><?php echo e($rencontre->stade); ?></td>
                            <td class="px-4 py-2">
                                <?php if(!is_null($rencontre->score_equipe1) && !is_null($rencontre->score_equipe2)): ?>
                                    <span class="font-bold"><?php echo e($rencontre->score_equipe1); ?> - <?php echo e($rencontre->score_equipe2); ?></span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2">
                                <?php if($rencontre->mvp_libre): ?>
                                    <span class="italic text-blue-600 dark:text-blue-300"><?php echo e($rencontre->mvp_libre); ?></span>
                                <?php elseif($rencontre->mvp): ?>
                                    <?php echo e($rencontre->mvp->nom); ?> <?php echo e($rencontre->mvp->prenom); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="mt-6 flex justify-center">
        <?php echo e($rencontres->links()); ?>

    </div>
    <button onclick="window.history.back()" class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 transition">← Retour</button>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.getElementById('search-rencontres').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.rencontres-table tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/rencontres/index.blade.php ENDPATH**/ ?>