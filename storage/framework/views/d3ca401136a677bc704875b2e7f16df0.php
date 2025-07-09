
<?php $__env->startSection('title', 'Buteurs'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto py-8">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold mb-2 text-white uppercase tracking-wider">Classement des Top Buteurs par Pool</h1>
            <div class="text-base text-gray-400 font-semibold uppercase"><?php echo e($saison?->nom); ?></div>
        </div>
        <form method="GET" action="" class="flex items-center gap-4 px-4 py-3 rounded-lg bg-[#181d1f] border border-[#31363a] shadow-md">
            <label for="saison_id" class="text-gray-200 font-bold uppercase tracking-wide mr-2">Saison</label>
            <select name="saison_id" id="saison_id" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] focus:outline-none focus:ring-2 focus:ring-[#e2001a] font-semibold shadow-sm transition placeholder-gray-400">
                <?php $__currentLoopData = $saisons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>" <?php if(request('saison_id', $saison?->id) == $s->id): ?> selected <?php endif; ?> style="color:#23272a; background:#fff; font-weight:bold;"><?php echo e($s->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="ml-2 px-5 py-2 bg-gradient-to-r from-[#e2001a] to-[#b80016] text-white font-extrabold rounded shadow-lg hover:from-[#b80016] hover:to-[#e2001a] focus:outline-none focus:ring-2 focus:ring-[#6fcf97] transition">OK</button>
        </form>
    </div>
    <?php $__empty_1 = true; $__currentLoopData = $pools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-[#e2001a] mb-4 uppercase">Pool <?php echo e($pool->nom); ?></h2>
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full bg-[#181d1f] text-white rounded-lg">
                    <thead>
                        <tr class="bg-[#23272a] text-white uppercase text-base">
                            <th class="px-4 py-2 text-center font-extrabold">#</th>
                            <th class="px-4 py-2 text-center font-extrabold">Joueur</th>
                            <th class="px-4 py-2 text-center font-extrabold">Équipe</th>
                            <th class="px-4 py-2 text-center font-extrabold">Buts</th>
                            <th class="px-4 py-2 text-center font-extrabold">Matchs</th>
                            <th class="px-4 py-2 text-center font-extrabold">Ratio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pool->buteurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $buteur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-[#23272a] hover:bg-[#23272a] transition cursor-pointer">
                                <td class="px-4 py-2 text-center"><?php echo e($index + 1); ?></td>
                                <td class="px-4 py-2 font-bold text-center">
                                    <a href="<?php echo e(url('/joueurs/'.$buteur->id)); ?>" class="flex items-center gap-2 justify-center hover:underline text-white">
                                        <?php if($buteur->photo): ?>
                                            <img src="<?php echo e(asset('storage/'.$buteur->photo)); ?>" alt="Photo" class="h-10 w-10 rounded-full object-cover bg-gray-700 border border-[#23272a]">
                                        <?php else: ?>
                                            <span class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-8 w-8">
                                                    <circle cx="12" cy="8" r="4"/>
                                                    <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                                                </svg>
                                            </span>
                                        <?php endif; ?>
                                        <span><?php echo e($buteur->nom); ?> <?php echo e($buteur->prenom); ?></span>
                                    </a>
                                </td>
                                <td class="px-4 py-2 flex items-center gap-2 justify-center text-center">
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
                                <td class="px-4 py-2 font-extrabold text-lg text-center text-white"><?php echo e($buteur->buts_count ?? 0); ?></td>
                                <td class="px-4 py-2 text-gray-300 font-semibold text-center"><?php echo e($buteur->buts ? $buteur->buts->pluck('rencontre_id')->unique()->count() : 0); ?></td>
                                <td class="px-4 py-2 text-green-400 font-semibold text-center">
                                    <?php
                                        $matchs = $buteur->buts ? $buteur->buts->pluck('rencontre_id')->unique()->count() : 0;
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
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php
            $hasFilter = request()->has('saison_id') || request()->has('titre') || request()->has('auteur') || request()->has('q');
        ?>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded text-center">
            <?php if($hasFilter): ?>
                Aucun règlement ne correspond à vos critères de recherche.
                <?php
                    $activeFilters = collect([
                        request('saison_id') ? 'Saison' : null,
                        request('titre') ? 'Titre' : null,
                        request('auteur') ? 'Auteur' : null,
                        request('q') ? 'Recherche' : null,
                    ])->filter()->implode(', ');
                ?>
                <?php if($activeFilters): ?>
                    <br><span class="font-semibold">Filtres actifs :</span> <?php echo e($activeFilters); ?>

                <?php endif; ?>
            <?php else: ?>
                Aucun pool trouvé.
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/public/buteurs.blade.php ENDPATH**/ ?>