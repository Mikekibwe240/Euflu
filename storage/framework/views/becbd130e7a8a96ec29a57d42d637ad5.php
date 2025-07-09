
<?php $__env->startSection('title', 'TOPS BUTEURS'); ?>
<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-8">
    <div class="mb-6 flex justify-start">
        <a href="/admin/classement" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded shadow border border-yellow-500 transition">&larr; Retour</a>
    </div>
    <h1 class="text-3xl font-bold mb-8 text-center text-white">TOPS BUTEURS - Pool <?php echo e($pool->nom); ?></h1>
    <div class="overflow-x-auto rounded-lg shadow bg-bl-card border border-bl-border">
        <table class="min-w-full bg-bl-card text-white text-sm rounded-lg">
            <thead class="bg-[#23272a]">
                <tr>
                    <th class="px-2 py-2 text-white">PL</th>
                    <th class="px-2 py-2 text-left text-white">Joueur</th>
                    <th class="px-2 py-2 text-left text-white">Photo</th>
                    <th class="px-2 py-2 text-left text-white">Équipe</th>
                    <th class="px-2 py-2 text-white">Buts</th>
                    <th class="px-2 py-2 text-white">Matchs</th>
                    <th class="px-2 py-2 text-white">Ratio</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $buteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $buteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-b border-bl-border hover:bg-bl-dark transition cursor-pointer" onclick="window.location='<?php echo e(route('admin.joueurs.show', $buteur->id)); ?>'">
                    <td class="text-center font-bold text-white"><?php echo e($index + 1); ?></td>
                    <td class="font-semibold text-white">
                        <a href="<?php echo e(route('admin.joueurs.show', $buteur->id)); ?>" class="hover:underline"><?php echo e($buteur->nom); ?> <?php echo e($buteur->prenom); ?></a>
                    </td>
                    <td>
                        <?php if($buteur->photo): ?>
                            <img src="<?php echo e(asset('storage/'.$buteur->photo)); ?>" alt="Photo" class="h-10 w-10 rounded-full object-cover bg-bl-card border border-bl-border">
                        <?php else: ?>
                            <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-8 w-8">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="flex items-center gap-2 text-white">
                        <?php if($buteur->equipe): ?>
                            <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $buteur->equipe,'size' => 24]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($buteur->equipe),'size' => 24]); ?>
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
                            <span class="h-6 w-6 flex items-center justify-center rounded-full bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-5 w-5">
                                    <path d="M12 2C7.03 2 2.5 6.03 2.5 11c0 4.97 4.53 9 9.5 9s9.5-4.03 9.5-9c0-4.97-4.53-9-9.5-9zm0 16c-3.87 0-7-3.13-7-7 0-3.87 3.13-7 7-7s7 3.13 7 7c0 3.87-3.13 7-7 7z"/>
                                </svg>
                            </span>
                        <?php endif; ?>
                        <span><?php echo e($buteur->equipe->nom ?? '-'); ?></span>
                    </td>
                    <td class="text-center font-bold text-white"><?php echo e($buteur->buts_count ?? 0); ?></td>
                    <td class="text-center text-white">
                        <?php
                            $matchs = $buteur->buts ? $buteur->buts->pluck('rencontre_id')->unique()->count() : 0;
                        ?>
                        <?php echo e($matchs); ?>

                    </td>
                    <td class="text-center text-white">
                        <?php
                            $ratio = ($matchs > 0) ? round(($buteur->buts_count ?? 0) / $matchs, 2) : 0;
                        ?>
                        <?php echo e($ratio); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/classement_buteurs.blade.php ENDPATH**/ ?>