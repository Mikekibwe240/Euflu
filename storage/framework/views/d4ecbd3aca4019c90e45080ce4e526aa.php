
<?php $__env->startSection('title', 'Fiche du match'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto mt-10 mb-8">
    <div class="bg-[#23272a] rounded-xl shadow-lg border-b-4 border-[#6fcf97]">
        <div class="flex items-center justify-between px-6 pt-6">
            <a href="<?php echo e(url()->previous()); ?>" class="text-[#6fcf97] font-bold text-sm hover:underline flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                Journée <?php echo e($rencontre->journee ?? '-'); ?>

            </a>
            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider"><?php echo e($rencontre->stade ?? ''); ?></div>
        </div>
        <div class="text-center text-2xl font-extrabold text-white uppercase tracking-wider mt-2">HIGHLIGHTS</div>
        <div class="flex flex-col md:flex-row items-center justify-between px-6 py-6 gap-6">
            <div class="flex-1 flex flex-col items-center">
                <span class="text-white text-lg font-extrabold uppercase mb-2"><?php echo e($rencontre->equipe1->nom ?? $rencontre->equipe1_libre ?? '-'); ?></span>
                <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $rencontre->equipe1,'size' => '56']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rencontre->equipe1),'size' => '56']); ?>
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
            <div class="flex flex-col items-center justify-center">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-black text-white px-4 py-2 rounded text-3xl font-extrabold tracking-widest border-2 border-[#23272a]"><?php echo e($rencontre->score_equipe1 ?? '-'); ?></span>
                    <span class="text-white text-2xl font-extrabold">-</span>
                    <span class="bg-[#e2001a] text-white px-4 py-2 rounded text-3xl font-extrabold tracking-widest border-2 border-[#e2001a]"><?php echo e($rencontre->score_equipe2 ?? '-'); ?></span>
                </div>
                <div class="flex items-center justify-center gap-2">
                    <span class="text-xs text-gray-400 uppercase font-bold">FINAL</span>
                </div>
            </div>
            <div class="flex-1 flex flex-col items-center">
                <span class="text-white text-lg font-extrabold uppercase mb-2"><?php echo e($rencontre->equipe2->nom ?? $rencontre->equipe2_libre ?? '-'); ?></span>
                <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $rencontre->equipe2,'size' => '56']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rencontre->equipe2),'size' => '56']); ?>
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
        <div class="flex items-center justify-between px-6 pb-2">
            <div></div>
            <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider"><?php echo e($rencontre->date); ?> à <?php echo e($rencontre->heure); ?></div>
        </div>
        <div class="bg-[#181d1f] px-6 py-4 rounded-b-xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <div class="font-bold text-[#6fcf97] uppercase text-sm mb-1">Buteurs</div>
                    <ul class="text-white text-sm space-y-1">
                        <?php $__currentLoopData = $rencontre->buts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $but): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <span class="font-bold"><?php echo e($but->joueur?->nom); ?> <?php echo e($but->joueur?->prenom); ?></span>
                                <span class="text-xs text-gray-400"><?php echo e($but->minute ? $but->minute . "'" : ''); ?></span>
                                <span class="text-xs text-gray-400"><?php echo e($but->equipe_id == $rencontre->equipe1?->id ? $rencontre->equipe1?->nom : $rencontre->equipe2?->nom); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($rencontre->buts->isEmpty()): ?>
                            <li class="text-gray-500">Aucun but</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="flex-1">
                    <div class="font-bold text-[#e2001a] uppercase text-sm mb-1">Cartons</div>
                    <ul class="text-white text-sm space-y-1">
                        <?php $__currentLoopData = $rencontre->cartons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carton): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <span class="font-bold"><?php echo e($carton->joueur?->nom); ?> <?php echo e($carton->joueur?->prenom); ?></span>
                                <span class="text-xs text-gray-400"><?php echo e($carton->minute ? $carton->minute . "'" : ''); ?></span>
                                <span class="text-xs <?php echo e($carton->type == 'jaune' ? 'text-yellow-400' : 'text-red-500'); ?>"><?php echo e(ucfirst($carton->type)); ?></span>
                                <span class="text-xs text-gray-400 ml-2">
                                    <?php if($carton->equipe_id == $rencontre->equipe1?->id): ?>
                                        (<?php echo e($rencontre->equipe1?->nom); ?>)
                                    <?php elseif($carton->equipe_id == $rencontre->equipe2?->id): ?>
                                        (<?php echo e($rencontre->equipe2?->nom); ?>)
                                    <?php elseif($carton->equipe_libre_nom): ?>
                                        (<?php echo e($carton->equipe_libre_nom); ?>)
                                    <?php endif; ?>
                                </span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($rencontre->cartons->isEmpty()): ?>
                            <li class="text-gray-500">Aucun carton</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="flex-1">
                    <div class="font-bold text-[#6fcf97] uppercase text-sm mb-1">Homme du match</div>
                    <div class="text-white text-lg font-extrabold">
                        <?php if($rencontre->mvp): ?>
                            <?php echo e($rencontre->mvp->nom); ?> <?php echo e($rencontre->mvp->prenom); ?>

                            <span class="text-xs text-gray-400">
                                (
                                <?php if($rencontre->mvp->equipe?->nom): ?>
                                    <?php echo e($rencontre->mvp->equipe->nom); ?>

                                <?php elseif($rencontre->mvp_libre_equipe): ?>
                                    <?php echo e($rencontre->mvp_libre_equipe); ?>

                                <?php else: ?>
                                    Équipe inconnue
                                <?php endif; ?>
                                )
                            </span>
                        <?php elseif($rencontre->mvp_libre): ?>
                            <?php echo e($rencontre->mvp_libre); ?>

                            <span class="text-xs text-gray-400">
                                (
                                <?php echo e($rencontre->mvp_libre_equipe ?? 'Équipe inconnue'); ?>

                                )
                            </span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-xs text-gray-400 text-right">
                <?php if($rencontre->updatedBy): ?>
                    <span>Dernière modification par : <span class="font-bold"><?php echo e($rencontre->updatedBy->name); ?></span></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="flex justify-between items-center mb-4">
        <a href="<?php echo e(route('public.matchs.index')); ?>" class="text-[#6fcf97] font-bold text-sm hover:underline flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Retour à la liste des matchs
        </a>
    </div>
    <div class="flex justify-center mt-8">
        <a href="<?php echo e(route('public.match.pdf', ['id' => $rencontre->id])); ?>" class="px-8 py-3 bg-[#23272a] border-2 border-[#6fcf97] text-white font-bold rounded hover:bg-[#6fcf97] hover:text-[#23272a] transition" target="_blank">Télécharger la feuille de match (PDF)</a>
    </div>
    <div class="bg-[#181d1f] px-6 py-4 rounded-b-xl mt-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php $__currentLoopData = [$rencontre->equipe1, $rencontre->equipe2]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($equipe): ?>
                    <?php
                        $effectif = \App\Models\MatchEffectif::where('rencontre_id', $rencontre->id)->where('equipe_id', $equipe->id)->first();
                    ?>
                    <div>
                        <div class="font-bold text-[#6fcf97] uppercase text-base mb-2">Effectif <?php echo e($equipe->nom); ?></div>
                        <?php if($effectif): ?>
                            <div class="mb-2">
                                <span class="font-semibold text-white">Titulaires :</span>
                                <ul class="text-white text-sm space-y-1 mt-1">
                                    <?php $__currentLoopData = $effectif->joueurs->where('type', 'titulaire')->sortBy('ordre'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $titulaire): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($titulaire->joueur->nom ?? '-'); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <div class="mb-2">
                                <span class="font-semibold text-white">Remplaçants :</span>
                                <ul class="text-white text-sm space-y-1 mt-1">
                                    <?php $__currentLoopData = $effectif->joueurs->where('type', 'remplaçant')->sortBy('ordre'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remplacant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($remplacant->joueur->nom ?? '-'); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <div>
                                <span class="font-semibold text-white">Remplacements :</span>
                                <ul class="text-white text-sm space-y-1 mt-1">
                                    <?php $__empty_1 = true; $__currentLoopData = $effectif->remplacements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <li>
                                            <span class="font-bold"><?php echo e($remp->remplaçant->nom ?? '-'); ?></span>
                                            <?php if(!is_null($remp->minute)): ?>
                                                <span class="text-xs text-gray-400"><?php echo e($remp->minute); ?>'</span>
                                            <?php endif; ?>
                                            <span class="text-xs">a remplacé</span>
                                            <span class="font-bold"><?php echo e($remp->remplacé->nom ?? '-'); ?></span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <li class="text-gray-500">Aucun remplacement</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php else: ?>
                            <div class="text-gray-400 italic">Aucun effectif saisi</div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/public/match/show.blade.php ENDPATH**/ ?>