

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4 max-w-4xl">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 mb-6">
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
                        <span class="mt-2 font-semibold text-blue-800 dark:text-blue-200"><?php echo e($rencontre->equipe1->nom ?? $rencontre->equipe1_libre); ?></span>
                    <?php else: ?>
                        <span class="mt-2 text-gray-400">Non renseigné</span>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col items-center mx-4">
                    <span class="text-3xl font-extrabold text-gray-800 dark:text-white bg-blue-100 dark:bg-blue-900 px-4 py-2 rounded-lg shadow"><?php echo e($rencontre->score_equipe1 ?? '-'); ?> <span class="text-lg">-</span> <?php echo e($rencontre->score_equipe2 ?? '-'); ?></span>
                    <span class="text-xs text-gray-500 mt-1"><?php echo e($rencontre->type_rencontre ? ucfirst($rencontre->type_rencontre) : ''); ?></span>
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
                        <span class="mt-2 font-semibold text-blue-800 dark:text-blue-200"><?php echo e($rencontre->equipe2->nom ?? $rencontre->equipe2_libre); ?></span>
                    <?php else: ?>
                        <span class="mt-2 text-gray-400">Non renseigné</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="text-right">
                <div class="text-gray-600 dark:text-gray-300 mb-1"><?php echo e($rencontre->date); ?> à <?php echo e($rencontre->heure); ?></div>
                <div class="text-gray-600 dark:text-gray-300 mb-1">Stade : <?php echo e($rencontre->stade); ?></div>
                <?php if($rencontre->pool): ?>
                    <div class="text-gray-500 text-sm">Poule : <?php echo e($rencontre->pool->nom); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center mb-4">
            <div class="bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 rounded-lg px-4 py-2 text-center">
                <div class="font-bold text-lg">Homme du match</div>
                <div>
                    <?php if($rencontre->mvp): ?>
                        <?php echo e($rencontre->mvp->nom); ?> <?php echo e($rencontre->mvp->prenom); ?>

                        <span class="text-xs">
                            (
                            <?php echo e($rencontre->mvp->equipe->nom ?? $rencontre->mvp->equipe_libre_nom ?? 'Équipe inconnue'); ?>

                            )
                        </span>
                    <?php else: ?>
                        <span class="text-gray-400">Non renseigné</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 rounded-lg px-4 py-2 text-center">
                <div class="font-bold text-lg">Buts</div>
                <div><?php echo e($rencontre->buts->count()); ?></div>
            </div>
            <div class="bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-200 rounded-lg px-4 py-2 text-center">
                <div class="font-bold text-lg">Cartons</div>
                <div><?php echo e($rencontre->cartons->count()); ?></div>
            </div>
        </div>
        <div class="flex flex-wrap gap-2 justify-center mb-4">
            <a href="<?php echo e(route('admin.rencontres.edit', $rencontre)); ?>" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Modifier</a>
            <a href="<?php echo e(route('admin.rencontres.editResultat', $rencontre)); ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Saisir/Modifier résultat</a>
            <form action="<?php echo e(route('admin.rencontres.resetResultat', $rencontre)); ?>" method="POST" class="inline" onsubmit="return confirm('Supprimer tous les résultats de cette rencontre ?');">
                <?php echo csrf_field(); ?>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">Supprimer les résultats</button>
            </form>
            <form action="<?php echo e(route('admin.rencontres.destroy', $rencontre)); ?>" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette rencontre ? Cette action est irréversible.');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Supprimer</button>
            </form>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <h3 class="font-semibold mb-2 text-blue-700 dark:text-blue-300">Buteurs <?php echo e($rencontre->equipe1?->nom ?? $rencontre->equipe1_libre ?? '-'); ?></h3>
            <ul>
                <?php
                    $buts1 = $rencontre->buts->filter(function($but) use ($rencontre) {
                        if ($rencontre->equipe1) {
                            return $but->equipe_id == $rencontre->equipe1->id;
                        } elseif ($rencontre->equipe1_libre) {
                            return is_null($but->equipe_id) && ($but->equipe_libre_nom ?? null) == $rencontre->equipe1_libre;
                        }
                        return false;
                    });
                ?>
                <?php $__currentLoopData = $buts1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $but): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <?php if($but->joueur): ?>
                            <?php echo e($but->joueur->nom); ?> <?php echo e($but->joueur->prenom); ?>

                            <?php if($but->minute): ?> (<?php echo e($but->minute); ?>') <?php endif; ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($buts1->isEmpty()): ?>
                    <li class="text-gray-400">Aucun</li>
                <?php endif; ?>
            </ul>
        </div>
        <div>
            <h3 class="font-semibold mb-2 text-blue-700 dark:text-blue-300">Buteurs <?php echo e($rencontre->equipe2?->nom ?? $rencontre->equipe2_libre ?? '-'); ?></h3>
            <ul>
                <?php
                    $buts2 = $rencontre->buts->filter(function($but) use ($rencontre) {
                        if ($rencontre->equipe2) {
                            return $but->equipe_id == $rencontre->equipe2->id;
                        } elseif ($rencontre->equipe2_libre) {
                            return is_null($but->equipe_id) && ($but->equipe_libre_nom ?? null) == $rencontre->equipe2_libre;
                        }
                        return false;
                    });
                ?>
                <?php $__currentLoopData = $buts2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $but): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <?php if($but->joueur): ?>
                            <?php echo e($but->joueur->nom); ?> <?php echo e($but->joueur->prenom); ?>

                            <?php if($but->minute): ?> (<?php echo e($but->minute); ?>') <?php endif; ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($buts2->isEmpty()): ?>
                    <li class="text-gray-400">Aucun</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <h3 class="font-semibold mb-2 text-yellow-700 dark:text-yellow-300">Cartons <?php echo e($rencontre->equipe1?->nom ?? $rencontre->equipe1_libre ?? '-'); ?></h3>
            <ul>
                <?php
                    $cartons1 = $rencontre->cartons->filter(function($carton) use ($rencontre) {
                        if ($rencontre->equipe1) {
                            return $carton->equipe_id == $rencontre->equipe1->id;
                        } elseif ($rencontre->equipe1_libre) {
                            return is_null($carton->equipe_id) && ($carton->equipe_libre_nom ?? null) == $rencontre->equipe1_libre;
                        }
                        return false;
                    });
                ?>
                <?php $__currentLoopData = $cartons1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carton): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <?php if($carton->joueur): ?>
                            <?php echo e($carton->joueur->nom); ?> <?php echo e($carton->joueur->prenom); ?>

                            - <span class="<?php echo e($carton->type == 'jaune' ? 'text-yellow-600' : 'text-red-600'); ?>"><?php echo e(ucfirst($carton->type)); ?></span>
                            <?php if($carton->minute): ?> (<?php echo e($carton->minute); ?>') <?php endif; ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($cartons1->isEmpty()): ?>
                    <li class="text-gray-400">Aucun</li>
                <?php endif; ?>
            </ul>
        </div>
        <div>
            <h3 class="font-semibold mb-2 text-yellow-700 dark:text-yellow-300">Cartons <?php echo e($rencontre->equipe2?->nom ?? $rencontre->equipe2_libre ?? '-'); ?></h3>
            <ul>
                <?php
                    $cartons2 = $rencontre->cartons->filter(function($carton) use ($rencontre) {
                        if ($rencontre->equipe2) {
                            return $carton->equipe_id == $rencontre->equipe2->id;
                        } elseif ($rencontre->equipe2_libre) {
                            return is_null($carton->equipe_id) && ($carton->equipe_libre_nom ?? null) == $rencontre->equipe2_libre;
                        }
                        return false;
                    });
                ?>
                <?php $__currentLoopData = $cartons2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carton): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <?php if($carton->joueur): ?>
                            <?php echo e($carton->joueur->nom); ?> <?php echo e($carton->joueur->prenom); ?>

                            - <span class="<?php echo e($carton->type == 'jaune' ? 'text-yellow-600' : 'text-red-600'); ?>"><?php echo e(ucfirst($carton->type)); ?></span>
                            <?php if($carton->minute): ?> (<?php echo e($carton->minute); ?>') <?php endif; ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($cartons2->isEmpty()): ?>
                    <li class="text-gray-400">Aucun</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 mb-6 mt-8">
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
                                <span class="font-semibold text-gray-900 dark:text-gray-100">Titulaires :</span>
                                <ul class="text-gray-900 dark:text-gray-100 text-sm space-y-1 mt-1">
                                    <?php $__currentLoopData = $effectif->joueurs->where('type', 'titulaire')->sortBy('ordre'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $titulaire): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($titulaire->joueur->nom ?? '-'); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <div class="mb-2">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">Remplaçants :</span>
                                <ul class="text-gray-900 dark:text-gray-100 text-sm space-y-1 mt-1">
                                    <?php $__currentLoopData = $effectif->joueurs->where('type', 'remplaçant')->sortBy('ordre'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remplacant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($remplacant->joueur->nom ?? '-'); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 dark:text-gray-100">Remplacements :</span>
                                <ul class="text-gray-900 dark:text-gray-100 text-sm space-y-1 mt-1">
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
    <div class="mt-4 text-xs text-gray-500 text-right">
        <?php if($rencontre->updatedBy): ?>
            <span>Dernière modification par : <span class="font-bold"><?php echo e($rencontre->updatedBy->name); ?></span></span>
        <?php endif; ?>
    </div>
    <div class="flex justify-between mt-8">
        <a href="<?php echo e(route('admin.rencontres.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded shadow">
            &#8592; Retour à la liste des rencontres
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/rencontres/show.blade.php ENDPATH**/ ?>