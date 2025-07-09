
<?php $__env->startSection('title', 'Matchs EUFLU'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto mt-10 mb-8 px-2 sm:px-4 md:px-6 lg:px-0">
    <?php
        $journeeActive = request()->filled('journee') && request('journee') !== '';
    ?>
    <?php if($journeeActive): ?>
        <div class="text-2xl md:text-4xl font-extrabold text-white uppercase tracking-wider mb-2">
            JOURNÉE <span class="text-[#6fcf97]"><?php echo e(request('journee')); ?></span>
        </div>
    <?php endif; ?>
    <div class="text-sm md:text-base text-gray-400 font-semibold uppercase mb-4 md:mb-8">
        SAISON <?php echo e($saisons->firstWhere('id', request('saison_id', $saison?->id))?->nom ?? ($saison?->nom ?? ($saisons->first()?->nom ?? ''))); ?>

    </div>
    <div class="flex flex-wrap md:flex-row md:items-end md:justify-between mb-6 md:mb-8 gap-2 md:gap-4">
        <form method="GET" action="" class="flex flex-wrap items-center gap-2 md:gap-4 px-2 md:px-4 py-2 md:py-3 rounded-lg bg-[#181d1f] border border-[#31363a] shadow-md w-full md:w-auto">
            <select name="journee" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] font-semibold focus:ring-2 focus:ring-[#6fcf97]" style="background-color: #181d1f !important;">
                <option value="">Toutes les journées</option>
                <?php $__currentLoopData = ($allJournees ?? $rencontres->pluck('journee')->unique()->sort()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($j); ?>" <?php if(request('journee', $currentJournee ?? null) == $j): ?> selected <?php endif; ?> style="background-color: #181d1f; color: #6fcf97;">Journée <?php echo e($j); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="saison_id" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] font-semibold focus:ring-2 focus:ring-[#6fcf97]" style="background-color: #181d1f !important;">
                <option value="">Toutes les saisons</option>
                <?php $__currentLoopData = $saisons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>" <?php if(request('saison_id', $saison?->id) == $s->id): ?> selected <?php endif; ?> style="background-color: #181d1f; color: #6fcf97;"><?php echo e($s->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="equipe_id" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] font-semibold focus:ring-2 focus:ring-[#6fcf97]" style="background-color: #181d1f !important;">
                <option value="">Tous les clubs</option>
                <?php $__currentLoopData = $equipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($c->id); ?>" <?php if(request('equipe_id') == $c->id): ?> selected <?php endif; ?> style="background-color: #181d1f; color: #6fcf97;"><?php echo e($c->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="pool_id" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] font-semibold focus:ring-2 focus:ring-[#6fcf97]" style="background-color: #181d1f !important;">
                <option value="">Tous les pools</option>
                <option value="A" <?php if(request('pool_id') == 'A'): ?> selected <?php endif; ?> style="background-color: #181d1f; color: #6fcf97;">A</option>
                <option value="B" <?php if(request('pool_id') == 'B'): ?> selected <?php endif; ?> style="background-color: #181d1f; color: #6fcf97;">B</option>
                <option value="AMICAL" <?php if(request('pool_id') == 'AMICAL'): ?> selected <?php endif; ?> style="background-color: #181d1f; color: #6fcf97;">AMICAL</option>
            </select>
            <button type="submit" class="ml-2 px-5 py-2 bg-gradient-to-r from-[#e2001a] to-[#b80016] text-white font-extrabold rounded shadow-lg hover:from-[#b80016] hover:to-[#e2001a] focus:outline-none focus:ring-2 focus:ring-[#6fcf97] transition">OK</button>
        </form>
    </div>
    <div class="space-y-3 md:space-y-4">
        <div class="hidden md:grid grid-cols-8 gap-2 md:gap-4 px-2 md:px-6 py-2 text-[#6fcf97] font-bold uppercase text-xs tracking-wider">
            <div class="text-center">Date</div>
            <div class="text-center">Equipe 1</div>
            <div></div>
            <div class="text-center">Equipe 2</div>
            <div class="text-center">Heure</div>
            <div class="text-center">Score</div>
            <div class="text-center">MVP</div>
            <div class="text-center">Pool</div>
        </div>
        <?php $__currentLoopData = $rencontres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(url('/matchs/' . $match->id)); ?>" class="block group">
            <div class="grid grid-cols-1 md:grid-cols-8 items-center bg-[#181d1f] rounded-lg shadow px-2 md:px-6 py-3 md:py-4 border-l-4 border-[#6fcf97] gap-2 md:gap-4 transition duration-200 group-hover:bg-[#23272a] group-hover:shadow-lg group-hover:border-[#e2001a] cursor-pointer overflow-x-auto md:overflow-x-visible min-w-0">
                <div class="text-gray-400 text-xs font-bold uppercase md:col-span-1 col-span-full mb-2 md:mb-0 text-center">
                    <?php
                        $date = \Carbon\Carbon::parse($match->date)->startOfDay();
                        $today = \Carbon\Carbon::now()->startOfDay();
                        $diff = $date->diffInDays($today, false);
                        if ($diff === 0) {
                            $relative = "Aujourd'hui";
                        } elseif ($diff === 1) {
                            $relative = 'Hier';
                        } elseif ($diff === 2) {
                            $relative = 'Avant-hier';
                        } elseif ($diff === -1) {
                            $relative = 'Demain';
                        } elseif ($diff === -2) {
                            $relative = 'Après-demain';
                        } elseif ($diff < 0) {
                            $relative = 'Dans ' . abs($diff) . ' jours';
                        } else {
                            $relative = 'Il y a ' . $diff . ' jours';
                        }
                    ?>
                    <?php echo e($relative); ?>

                    <span class="block text-[10px] text-gray-500 font-normal"><?php echo e(\Carbon\Carbon::parse($match->date)->locale('fr')->translatedFormat('l d F')); ?></span>
                </div>
                <div class="flex items-center gap-2 min-w-0 justify-center">
                    <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $match->equipe1,'size' => 28]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($match->equipe1),'size' => 28]); ?>
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
                    <span class="font-extrabold text-white text-base md:text-lg truncate"><?php echo e($match->equipe1->nom); ?></span>
                </div>
                <div class="text-center font-bold text-[#e2001a] text-lg md:text-xl">-</div>
                <div class="flex items-center gap-2 min-w-0 justify-center">
                    <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $match->equipe2,'size' => 28]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($match->equipe2),'size' => 28]); ?>
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
                    <span class="font-extrabold text-white text-base md:text-lg truncate"><?php echo e($match->equipe2->nom); ?></span>
                </div>
                <div class="text-xs md:text-base text-gray-400 text-center">
                    <?php echo e($match->heure ? \Carbon\Carbon::parse($match->heure)->format('H:i') : '-'); ?>

                </div>
                <div class="text-xs md:text-base text-white text-center"><?php echo e($match->score_equipe1 !== null && $match->score_equipe2 !== null ? $match->score_equipe1 . ' - ' . $match->score_equipe2 : '-'); ?></div>
                <div class="text-xs md:text-base text-[#6fcf97] text-center">
                    <?php if(is_object($match->mvp)): ?>
                        <?php echo e($match->mvp->nom); ?> <?php echo e($match->mvp->prenom); ?>

                    <?php elseif(is_array($match->mvp)): ?>
                        <?php echo e($match->mvp['nom'] ?? ''); ?> <?php echo e($match->mvp['prenom'] ?? ''); ?>

                    <?php elseif($match->mvp): ?>
                        <?php echo e($match->mvp); ?>

                    <?php else: ?>
                        -
                    <?php endif; ?>
                </div>
                <div class="text-xs md:text-base text-gray-400 text-center"><?php echo e($match->pool ? ($match->pool->nom ?? '-') : ($match->type === 'amical' ? 'Amical' : '-')); ?></div>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="flex justify-center mt-4 gap-4">
        <?php if(isset($prevJournee) && $prevJournee): ?>
            <a href="?journee=<?php echo e($prevJournee); ?>&saison_id=<?php echo e(request('saison_id', $saisons->first()?->id)); ?>" class="px-8 py-3 bg-[#23272a] border-2 border-[#6fcf97] text-white font-bold rounded hover:bg-[#6fcf97] hover:text-[#23272a] transition">&larr; Journée <?php echo e($prevJournee); ?></a>
        <?php endif; ?>
        <?php if(isset($nextJournee) && $nextJournee): ?>
            <a href="?journee=<?php echo e($nextJournee); ?>&saison_id=<?php echo e(request('saison_id', $saisons->first()?->id)); ?>" class="px-8 py-3 bg-[#23272a] border-2 border-[#6fcf97] text-white font-bold rounded hover:bg-[#6fcf97] hover:text-[#23272a] transition">Journée <?php echo e($nextJournee); ?> &rarr;</a>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/public/matchs.blade.php ENDPATH**/ ?>