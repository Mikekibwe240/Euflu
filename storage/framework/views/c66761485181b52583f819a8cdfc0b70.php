

<?php $__env->startSection('title', 'Détail du joueur'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-[#181d1f] rounded-lg shadow p-6 mb-8 flex flex-col md:flex-row items-center gap-8 border border-[#23272a]">
        <div class="flex-shrink-0 flex flex-col items-center">
            <?php if($joueur->photo): ?>
                <img src="<?php echo e(asset('storage/' . $joueur->photo)); ?>" alt="Photo <?php echo e($joueur->nom); ?>" class="h-36 w-36 rounded-full object-cover border-4 border-[#e2001a] shadow mb-4">
            <?php else: ?>
                <div class="h-36 w-36 flex items-center justify-center rounded-full bg-gray-700 mb-4 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-24 w-24">
                        <circle cx="12" cy="8" r="8"/>
                        <path d="M4 20c0-5 4.134-9 8-9s8 4 8 9v1H4v-1z"/>
                    </svg>
                </div>
            <?php endif; ?>
            <div class="text-3xl font-extrabold text-white mb-2 uppercase tracking-wider"><?php echo e($joueur->nom); ?> <span class="font-light"><?php echo e($joueur->prenom); ?></span></div>
            <div class="flex items-center gap-2 text-gray-300 mb-1">
                <?php if($joueur->equipe): ?>
                    <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $joueur->equipe,'size' => 28]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($joueur->equipe),'size' => 28]); ?>
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
                <span class="font-semibold"><?php echo e($joueur->equipe->nom ?? 'Sans équipe'); ?></span>
            </div>
            <div class="text-gray-400 mb-1">Poste : <span class="font-semibold text-white"><?php echo e($joueur->poste ?? '-'); ?></span></div>
            <div class="text-gray-400 mb-1">Date de naissance : <span class="font-semibold text-white"><?php echo e($joueur->date_naissance ?? '-'); ?></span></div>
            <?php if($joueur->equipe): ?>
                <a href="<?php echo e(url('/equipes/'.$joueur->equipe->id)); ?>" class="mt-2 inline-block bg-[#e2001a] text-white px-4 py-1 rounded-full text-xs font-bold shadow hover:bg-[#b80015] transition">Voir l'équipe</a>
            <?php endif; ?>
        </div>
        <div class="flex-1 w-full">
            <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-2">
                <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-[#e4572e]' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M13 16h-1v-4h-1m4 4h-1v-4h-1m-4 4h-1v-4h-1m4 4h-1v-4h-1'/>
                </svg>
                Statistiques
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-[#23272a] rounded-2xl p-8 flex flex-col items-center shadow border-2 border-[#e4572e] w-full max-w-xs mx-auto break-words text-center">
                    <div class="text-5xl font-extrabold text-[#e4572e] mb-2 flex items-center gap-2 break-words">
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-8 w-8' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 6v6l4 2'/>
                        </svg>
                        <?php echo e(isset($joueur->buts) ? $joueur->buts->count() : 0); ?>

                    </div>
                    <div class="text-lg text-white font-semibold tracking-wide uppercase break-words">Buts marqués</div>
                </div>
                <div class="bg-[#23272a] rounded-2xl p-8 flex flex-col items-center shadow border-2 border-[#2563eb] w-full max-w-xs mx-auto break-words text-center">
                    <div class="text-5xl font-extrabold text-[#2563eb] mb-2 flex items-center gap-2 break-words">
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-8 w-8' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'/>
                        </svg>
                        <?php echo e(isset($joueur->buts) ? $joueur->buts->pluck('rencontre_id')->unique()->count() : 0); ?>

                    </div>
                    <div class="text-lg text-white font-semibold tracking-wide uppercase break-words">Matchs joués</div>
                </div>
                <div class="bg-[#23272a] rounded-2xl p-8 flex flex-col items-center shadow border-2 border-yellow-400 w-full max-w-xs mx-auto break-words text-center">
                    <div class="text-5xl font-extrabold text-yellow-400 mb-2 flex items-center gap-2 break-words">
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-8 w-8' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z'/>
                        </svg>
                        <?php
                            $ratio = (isset($joueur->buts) && $joueur->buts->pluck('rencontre_id')->unique()->count() > 0)
                                ? round($joueur->buts->count() / $joueur->buts->pluck('rencontre_id')->unique()->count(), 2)
                                : 0;
                        ?>
                        <?php echo e($ratio); ?>

                    </div>
                    <div class="text-lg text-white font-semibold tracking-wide uppercase break-words">Ratio Buts / Match</div>
                </div>
            </div>
            <div class="bg-[#23272a] rounded-lg p-4 mt-4 border border-[#23272a]">
                <h3 class="text-lg font-bold text-white mb-2">Informations</h3>
                <ul class="text-gray-300 text-sm space-y-1">
                    <li><span class="font-semibold text-white">Nom complet :</span> <?php echo e($joueur->nom); ?> <?php echo e($joueur->prenom); ?></li>
                    <li><span class="font-semibold text-white">Poste :</span> <?php echo e($joueur->poste ?? '-'); ?></li>
                    <li><span class="font-semibold text-white">Date de naissance :</span> <?php echo e($joueur->date_naissance ?? '-'); ?></li>
                    <li><span class="font-semibold text-white">Équipe :</span> <?php echo e($joueur->equipe->nom ?? 'Sans équipe'); ?></li>
                    <li><span class="font-semibold text-white">Numéro de licence :</span> <span class="font-mono"><?php echo e($joueur->numero_licence ?? '-'); ?></span></li>
                    <li><span class="font-semibold text-white">Numéro (dossard) :</span> <span class="font-mono"><?php echo e($joueur->numero_dossard ?? '-'); ?></span></li>
                    <li><span class="font-semibold text-white">Nationalité :</span> <?php echo e($joueur->nationalite ?? '-'); ?></li>
                </ul>
            </div>
            <div class="bg-[#23272a] rounded-lg p-4 mt-8 border border-[#23272a]">
                <h3 class="text-lg font-bold text-white mb-2">Historique des clubs</h3>
                <?php if($joueur->transferts->isEmpty()): ?>
                    <p class="text-gray-400 italic">Ce joueur n’a pas encore changé de club ou n’a pas d’historique de transfert.</p>
                <?php else: ?>
                    <ul class="divide-y divide-gray-700">
                        <?php $__currentLoopData = $joueur->transferts->sortByDesc('date'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transfert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="py-2 flex items-center gap-4">
                                <span class="text-gray-200">
                                    <?php
                                        $date = $transfert->date ? \Carbon\Carbon::parse($transfert->date)->format('d/m/Y') : '';
                                        $from = $transfert->fromEquipe->nom ?? 'Libre';
                                        $to = $transfert->toEquipe->nom ?? 'Libre';
                                    ?>
                                    <?php if($transfert->type === 'transfert'): ?>
                                        Le <?php echo e($date); ?> : Transféré de <b><?php echo e($from); ?></b> à <b><?php echo e($to); ?></b>
                                    <?php elseif($transfert->type === 'affectation'): ?>
                                        Le <?php echo e($date); ?> : Affecté à <b><?php echo e($to); ?></b>
                                    <?php elseif($transfert->type === 'liberation'): ?>
                                        Le <?php echo e($date); ?> : Libéré de <b><?php echo e($from); ?></b>
                                    <?php else: ?>
                                        Le <?php echo e($date); ?> : Mouvement de club
                                    <?php endif; ?>
                                </span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="flex justify-between">
        <a href="<?php echo e(url()->previous()); ?>" class="inline-block bg-[#23272a] text-white font-bold px-6 py-2 rounded-full shadow hover:bg-[#e2001a] transition-all duration-300 font-inter">← Retour</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/public/joueur_show.blade.php ENDPATH**/ ?>