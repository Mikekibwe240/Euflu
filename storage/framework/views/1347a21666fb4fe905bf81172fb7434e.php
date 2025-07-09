

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4 max-w-4xl">
    <div class="bg-bl-card rounded-xl shadow-lg p-6 mb-6 border border-bl-border">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
            <div class="flex items-center gap-4">
                <div class="flex flex-col items-center">
                    <?php if($rencontre->equipe1): ?>
                        <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $rencontre->equipe1,'size' => '64']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rencontre->equipe1),'size' => '64']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => (object)['nom'=>$rencontre->equipe1_libre],'size' => '64']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((object)['nom'=>$rencontre->equipe1_libre]),'size' => '64']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => null,'size' => '64']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'size' => '64']); ?>
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
                    <?php if($rencontre->equipe1 || $rencontre->equipe1_libre): ?>
                        <span class="mt-2 font-semibold text-white"><?php echo e($rencontre->equipe1->nom ?? $rencontre->equipe1_libre); ?></span>
                    <?php else: ?>
                        <span class="mt-2 text-gray-400">Non renseigné</span>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col items-center mx-4">
                    <span class="text-3xl font-extrabold text-white bg-bl-accent px-4 py-2 rounded-lg shadow"><?php echo e($rencontre->score_equipe1 ?? '-'); ?> <span class="text-lg">-</span> <?php echo e($rencontre->score_equipe2 ?? '-'); ?></span>
                    <span class="text-xs text-gray-400 mt-1"><?php echo e($rencontre->type_rencontre ? ucfirst($rencontre->type_rencontre) : ''); ?></span>
                </div>
                <div class="flex flex-col items-center">
                    <?php if($rencontre->equipe2): ?>
                        <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $rencontre->equipe2,'size' => '64']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rencontre->equipe2),'size' => '64']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => (object)['nom'=>$rencontre->equipe2_libre],'size' => '64']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((object)['nom'=>$rencontre->equipe2_libre]),'size' => '64']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => null,'size' => '64']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'size' => '64']); ?>
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
                    <?php if($rencontre->equipe2 || $rencontre->equipe2_libre): ?>
                        <span class="mt-2 font-semibold text-white"><?php echo e($rencontre->equipe2->nom ?? $rencontre->equipe2_libre); ?></span>
                    <?php else: ?>
                        <span class="mt-2 text-gray-400">Non renseigné</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="text-right">
                <div class="text-gray-400 mb-1"><?php echo e($rencontre->date); ?> à <?php echo e(\Carbon\Carbon::parse($rencontre->heure)->format('H:i')); ?></div>
                <div class="text-gray-400 mb-1">Stade : <?php echo e($rencontre->stade); ?></div>
                <?php if($rencontre->pool): ?>
                    <div class="text-gray-400 text-sm">Poule : <?php echo e($rencontre->pool->nom); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center mb-4">
            <div class="bg-bl-card border border-bl-border text-white rounded-lg px-4 py-2 text-center">
                <div class="font-bold text-lg">Homme du match</div>
                <div>
                    <?php if($rencontre->mvp): ?>
                        <?php echo e($rencontre->mvp->nom); ?> <?php echo e($rencontre->mvp->prenom); ?>

                        <span class="text-xs">
                            (
                            <?php echo e($rencontre->mvp->equipe->nom ?? $rencontre->mvp->equipe_libre_nom ?? 'Équipe inconnue'); ?>

                            )
                        </span>
                    <?php elseif($rencontre->mvp_libre): ?>
                        <span class="italic"><?php echo e($rencontre->mvp_libre); ?></span>
                    <?php else: ?>
                        <span class="text-gray-400">Non attribué</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Résultat action buttons -->
        <div class="flex gap-4 mb-6">
            <a href="<?php echo e(url('/admin/matchs/' . $rencontre->id . '/resultat')); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 border border-yellow-500 transition">Saisir/Modifier résultats</a>
            <form action="<?php echo e(url('/admin/matchs/' . $rencontre->id . '/reset-resultat')); ?>" method="POST" onsubmit="return confirm('Supprimer le résultat de cette rencontre ?');">
                <?php echo csrf_field(); ?>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">Supprimer résultats</button>
            </form>
        </div>
        <!-- Effectifs section -->
        <div class="bg-bl-card rounded-xl shadow-lg p-6 mb-6 border border-bl-border">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php $__currentLoopData = [$rencontre->equipe1, $rencontre->equipe2]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($equipe): ?>
                        <?php
                            $effectif = \App\Models\MatchEffectif::where('rencontre_id', $rencontre->id)->where('equipe_id', $equipe->id)->first();
                        ?>
                        <div>
                            <div class="font-bold text-white uppercase text-base mb-2">Effectif <?php echo e($equipe->nom); ?></div>
                            <?php if($effectif): ?>
                                <div class="mb-2">
                                    <span class="font-semibold text-blue-500">Titulaires :</span>
                                    <ul class="text-white text-sm space-y-1 mt-1">
                                        <?php $__currentLoopData = $effectif->joueurs->where('type', 'titulaire')->sortBy('ordre'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $titulaire): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <span class="inline-block bg-gray-700 text-[#6fcf97] font-bold rounded px-2 py-0.5 mr-2 text-xs align-middle"><?php echo e($titulaire->joueur->numero_dossard ?? '-'); ?></span>
                                                <?php echo e($titulaire->joueur->nom ?? '-'); ?>

                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <div class="mb-2">
                                    <span class="font-semibold text-yellow-500">Remplaçants :</span>
                                    <ul class="text-white text-sm space-y-1 mt-1">
                                        <?php $__currentLoopData = $effectif->joueurs->where('type', 'remplaçant')->sortBy('ordre'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remplacant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <span class="inline-block bg-gray-700 text-yellow-400 font-bold rounded px-2 py-0.5 mr-2 text-xs align-middle"><?php echo e($remplacant->joueur->numero_dossard ?? '-'); ?></span>
                                                <?php echo e($remplacant->joueur->nom ?? '-'); ?>

                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <div>
                                    <span class="font-semibold text-green-500">Remplacements :</span>
                                    <ul class="text-white text-sm space-y-1 mt-1">
                                        <?php $__empty_1 = true; $__currentLoopData = $effectif->remplacements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <li>
                                                <span class="inline-block bg-gray-700 text-yellow-400 font-bold rounded px-2 py-0.5 mr-2 text-xs align-middle"><?php echo e($remp->remplaçant->numero_dossard ?? '-'); ?></span>
                                                <span class="font-bold"><?php echo e($remp->remplaçant->nom ?? '-'); ?></span>
                                                <?php if(!is_null($remp->minute)): ?>
                                                    <span class="text-xs text-gray-400"><?php echo e($remp->minute); ?>'</span>
                                                <?php endif; ?>
                                                <span class="text-xs">a remplacé</span>
                                                <span class="inline-block bg-gray-700 text-blue-400 font-bold rounded px-2 py-0.5 mx-2 text-xs align-middle"><?php echo e($remp->remplacé->numero_dossard ?? '-'); ?></span>
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
        <div class="flex gap-4 mb-6">
            <a href="<?php echo e(route('admin.rencontres.edit', $rencontre)); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 border border-yellow-500 transition">Modifier</a>
            <form action="<?php echo e(route('admin.rencontres.destroy', $rencontre)); ?>" method="POST" onsubmit="return confirm('Supprimer définitivement cette rencontre ?');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">Supprimer</button>
            </form>
            <a href="<?php echo e(route('admin.rencontres.index')); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow border border-yellow-500 ml-auto transition">← Retour à la liste</a>
        </div>
    </div>
    <!-- Section infos match comme la fiche publique -->
    <div class="bg-bl-card rounded-xl shadow-lg border-b-4 border-bl-accent mb-6 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex-1">
                <div class="font-bold text-white uppercase text-sm mb-1">Buteurs</div>
                <ul class="text-white text-sm space-y-1">
                    <?php $__currentLoopData = $rencontre->buts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $but): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <?php if($but->joueur): ?>
                                <span class="font-bold"><?php echo e($but->joueur?->nom); ?> <?php echo e($but->joueur?->prenom); ?></span>
                            <?php elseif($but->nom_libre): ?>
                                <span class="italic font-bold"><?php echo e($but->nom_libre); ?></span>
                            <?php endif; ?>
                            <span class="text-xs text-gray-400"><?php echo e($but->minute ? $but->minute . "'" : ''); ?></span>
                            <span class="text-xs text-gray-400">
                                <?php if($but->equipe_id == $rencontre->equipe1?->id): ?>
                                    <?php echo e($rencontre->equipe1?->nom); ?>

                                <?php elseif($but->equipe_id == $rencontre->equipe2?->id): ?>
                                    <?php echo e($rencontre->equipe2?->nom); ?>

                                <?php elseif($but->equipe_libre_nom): ?>
                                    <?php echo e($but->equipe_libre_nom); ?>

                                <?php endif; ?>
                            </span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($rencontre->buts->isEmpty()): ?>
                        <li class="text-gray-500">Aucun but</li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="flex-1">
                <div class="font-bold text-white uppercase text-sm mb-1">Cartons</div>
                <ul class="text-white text-sm space-y-1">
                    <?php $__currentLoopData = $rencontre->cartons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carton): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <?php if($carton->joueur): ?>
                                <span class="font-bold"><?php echo e($carton->joueur?->nom); ?> <?php echo e($carton->joueur?->prenom); ?></span>
                            <?php elseif($carton->nom_libre): ?>
                                <span class="italic font-bold"><?php echo e($carton->nom_libre); ?></span>
                            <?php endif; ?>
                            <span class="text-xs text-gray-400"><?php echo e($carton->minute ? $carton->minute . "'" : ''); ?></span>
                            <span class="text-xs <?php echo e($carton->type == 'jaune' ? 'text-yellow-400' : 'text-white'); ?>"><?php echo e(ucfirst($carton->type)); ?></span>
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
                <div class="font-bold text-white uppercase text-sm mb-1">Homme du match</div>
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
                <span>Dernière modification par : <span class="font-bold"><?php echo e($rencontre->updatedBy->name); ?></span> le <?php echo e($rencontre->updated_at ? $rencontre->updated_at->format('d/m/Y à H:i') : ''); ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/rencontres/show.blade.php ENDPATH**/ ?>