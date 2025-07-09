

<?php $__env->startSection('title', 'Fiche Joueur'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-8">
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
    <div class="bg-bl-card rounded-lg shadow p-6 mb-8 flex flex-col md:flex-row items-center gap-8 border border-bl-border">
        <div class="flex-shrink-0 flex flex-col items-center">
            <?php if($joueur->photo): ?>
                <img src="<?php echo e(asset('storage/' . $joueur->photo)); ?>" alt="Photo <?php echo e($joueur->nom); ?>" class="h-32 w-32 rounded-full object-cover border-4 border-bl-border bg-bl-card mb-4" onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'h-32 w-32 flex items-center justify-center rounded-full bg-gray-700 mb-4\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#b0b0b0\' viewBox=\'0 0 24 24\' class=\'h-24 w-24\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z\'/></svg></div>'">
            <?php else: ?>
                <div class="h-32 w-32 flex items-center justify-center rounded-full bg-gray-700 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-24 w-24">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                    </svg>
                </div>
            <?php endif; ?>
            <div class="text-xl font-semibold text-white"><?php echo e($joueur->nom); ?> <?php echo e($joueur->prenom); ?></div>
            <div class="text-gray-400">Équipe : <?php echo e($joueur->equipe->nom ?? 'Sans équipe'); ?></div>
            <div class="text-gray-400">Poste : <?php echo e($joueur->poste ?? '-'); ?></div>
            <div class="text-gray-400">Date de naissance : <?php echo e($joueur->date_naissance ?? '-'); ?></div>
            <div class="text-gray-400">Numéro de licence : <span class="font-mono"><?php echo e($joueur->numero_licence ?? '-'); ?></span></div>
            <div class="text-gray-400">Numéro (dossard) : <span class="font-mono"><?php echo e($joueur->numero_dossard ?? '-'); ?></span></div>
            <div class="text-gray-400">Nationalité : <?php echo e($joueur->nationalite ?? '-'); ?></div>
        </div>
        <div class="flex-1 w-full">
            <h2 class="text-2xl font-semibold text-white mb-4">Statistiques</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-bl-card border border-bl-border rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-white mb-2"><?php echo e(isset($joueur->buts) ? $joueur->buts->count() : 0); ?></div>
                    <div class="text-lg text-white font-semibold">Buts marqués</div>
                </div>
                <div class="bg-bl-card border border-bl-border rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-green-400 mb-2"><?php echo e(isset($joueur->buts) ? $joueur->buts->pluck('rencontre_id')->unique()->count() : 0); ?></div>
                    <div class="text-lg text-green-400 font-semibold">Matchs joués</div>
                </div>
                <div class="bg-bl-card border border-bl-border rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-yellow-400 mb-2">
                        <?php
                            $ratio = (isset($joueur->buts) && $joueur->buts->pluck('rencontre_id')->unique()->count() > 0)
                                ? round($joueur->buts->count() / $joueur->buts->pluck('rencontre_id')->unique()->count(), 2)
                                : 0;
                        ?>
                        <?php echo e($ratio); ?>

                    </div>
                    <div class="text-lg text-yellow-400 font-semibold">Ratio Buts / Match</div>
                </div>
            </div>
            <div class="flex gap-4 mb-6">
                <a href="<?php echo e(route('admin.joueurs.edit', $joueur)); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 border border-yellow-500 transition">Modifier</a>
                <form action="<?php echo e(route('admin.joueurs.destroy', $joueur)); ?>" method="POST" onsubmit="return confirm('Supprimer définitivement ce joueur ?');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">Supprimer</button>
                </form>
                <a href="<?php echo e(route('admin.joueurs.index')); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow border border-yellow-500 ml-auto transition">← Retour à la liste</a>
            </div>
            <h3 class="font-semibold mb-2 text-white">Historique des clubs</h3>
            <?php if($joueur->transferts->isEmpty()): ?>
                <p class="text-gray-400 italic">Aucun historique de club.</p>
            <?php else: ?>
                <ul class="mb-4 text-sm">
                    <?php $__currentLoopData = $joueur->transferts->sortByDesc('date'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transfert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <?php echo e($transfert->date); ?> :
                            <?php if($transfert->type === 'transfert'): ?>
                                Transfert de <b><?php echo e($transfert->fromEquipe->nom ?? 'Libre'); ?></b> à <b><?php echo e($transfert->toEquipe->nom ?? 'Libre'); ?></b>
                            <?php elseif($transfert->type === 'affectation'): ?>
                                Affectation à <b><?php echo e($transfert->toEquipe->nom ?? 'Libre'); ?></b>
                            <?php elseif($transfert->type === 'liberation'): ?>
                                Libéré de <b><?php echo e($transfert->fromEquipe->nom ?? 'Libre'); ?></b>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/joueurs/show.blade.php ENDPATH**/ ?>