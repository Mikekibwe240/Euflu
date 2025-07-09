

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4 text-white">Règlements</h2>
    <div class="flex flex-wrap gap-4 mb-4">
        <button onclick="window.history.back()" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">← Retour</button>
        <a href="<?php echo e(route('admin.reglements.create')); ?>" class="bg-green-700 text-white px-4 py-2 rounded-lg shadow hover:bg-green-800 border border-green-700 transition">Ajouter un règlement</a>
        <a href="<?php echo e(route('admin.reglements.exportPdf', request()->all())); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">Exporter PDF</a>
    </div>
    <form method="GET" action="<?php echo e(route('admin.reglements.index')); ?>" class="mb-4 flex flex-wrap gap-4 items-end bg-bl-card p-4 rounded-lg shadow border border-bl-border">
        <div>
            <label class="block font-semibold text-gray-200">Saison</label>
            <select name="saison_id" class="form-select w-40 rounded border-bl-border bg-gray-800 text-white">
                <option value="all" <?php echo e(request('saison_id') === 'all' ? 'selected' : ''); ?>>Toutes</option>
                <?php $__currentLoopData = $saisons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>" <?php echo e(request('saison_id') == $s->id ? 'selected' : ''); ?>>
                        <?php echo e($s->nom ?? $s->annee); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-200">Titre</label>
            <input type="text" name="titre" class="form-input w-40 rounded border-bl-border bg-gray-800 text-white" placeholder="Titre" value="<?php echo e(request('titre')); ?>">
        </div>
        <div>
            <label class="block font-semibold text-gray-200">Auteur</label>
            <input type="text" name="auteur" class="form-input w-40 rounded border-bl-border bg-gray-800 text-white" placeholder="Auteur" value="<?php echo e(request('auteur')); ?>">
        </div>
        <div>
            <label class="block font-semibold text-gray-200">Recherche</label>
            <input type="text" name="q" class="form-input w-60 rounded border-bl-border bg-gray-800 text-white" placeholder="Contenu..." value="<?php echo e(request('q')); ?>">
        </div>
        <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-900 transition">Filtrer</button>
        <a href="<?php echo e(route('admin.reglements.index')); ?>" class="bg-gray-300 text-gray-800 px-4 py-2 rounded ml-2">Réinitialiser</a>
    </form>
    <?php if(session('success')): ?>
        <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'success','message' => session('success'),'class' => 'mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success','message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('success')),'class' => 'mb-4']); ?>
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
    <div class="overflow-x-auto rounded shadow">
    <table class="min-w-full bg-bl-card text-white rounded table-fixed border border-bl-border">
        <thead class="bg-[#23272a]">
            <tr>
                <th class="px-4 py-2 w-16 text-center text-white">N°</th>
                <th class="px-4 py-2 w-40 text-center text-white">Titre</th>
                <th class="px-4 py-2 w-32 text-center text-white">Saison</th>
                <th class="px-4 py-2 w-32 text-center text-white">Date</th>
                <th class="px-4 py-2 w-32 text-center text-white">Auteur</th>
                <th class="px-4 py-2 w-32 text-center text-white">Modifié par</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $reglements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reglement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-t border-bl-border hover:bg-bl-dark transition text-center align-middle cursor-pointer" onclick="window.location='<?php echo e(route('admin.reglements.show', $reglement)); ?>'">
                    <td class="px-4 py-2 font-bold"><?php echo e($reglement->id); ?></td>
                    <td class="px-4 py-2 font-semibold text-white underline"><?php echo e($reglement->titre); ?></td>
                    <td class="px-4 py-2"><?php echo e($reglement->saison->annee ?? '-'); ?></td>
                    <td class="px-4 py-2"><?php echo e($reglement->created_at->format('d/m/Y')); ?></td>
                    <td class="px-4 py-2"><?php echo e($reglement->user->name ?? '-'); ?></td>
                    <td class="px-4 py-2"><?php echo e($reglement->updatedBy->name ?? '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="py-4 text-center text-gray-500">Aucun règlement trouvé.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
    <div class="mt-4 flex justify-center">
        <?php echo e($reglements->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/reglements/index.blade.php ENDPATH**/ ?>