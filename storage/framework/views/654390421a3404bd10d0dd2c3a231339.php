
<?php $__env->startSection('title', 'Matchs Bundesliga Style'); ?>
<?php $__env->startSection('header'); ?>
<nav class="bg-[#23272a] shadow sticky top-0 z-50 border-b-4 border-[#6fcf97] bundesliga-header">
    <div class="max-w-6xl mx-auto px-4 py-0 flex items-center justify-between h-16">
        <div class="flex items-center gap-4">
            <span class="bundesliga-logo">EUFLU</span>
        </div>
        <div class="bundesliga-menu hidden md:flex gap-6 font-bold uppercase text-white text-sm tracking-wider">
            <a href="/" class="px-2 py-1">Accueil</a>
            <a href="/classement" class="px-2 py-1">Classement</a>
            <a href="/matchs" class="px-2 py-1">Fixation et Résultats</a>
            <a href="/equipes" class="px-2 py-1">Equipes</a>
            <a href="/joueurs" class="px-2 py-1">Joueurs</a>
            <a href="/buteurs" class="px-2 py-1">Buteurs</a>
            <a href="/articles" class="px-2 py-1">Actualités</a>
            <a href="/videos" class="px-2 py-1">Videos</a>
            <a href="/stats" class="px-2 py-1">Stats</a>
            <a href="/awards" class="px-2 py-1">Awards</a>
        </div>
    </div>
</nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto mt-10 mb-8">
    <div class="text-4xl font-extrabold text-white uppercase tracking-wider mb-2">
        JOURNÉE <span class="text-[#6fcf97]"><?php echo e(request('journee', 1)); ?></span>
    </div>
    <div class="text-base text-gray-400 font-semibold uppercase mb-8">
        SAISON <?php echo e($saisons->firstWhere('id', request('saison_id'))?->nom ?? ($saisons->first()?->nom ?? '')); ?>

    </div>
    <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-8 gap-4">
        <form method="GET" action="" class="flex items-center gap-4 px-4 py-3 rounded-lg bg-[#181d1f] border border-[#31363a] shadow-md">
            <select name="journee" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] font-semibold focus:ring-2 focus:ring-[#6fcf97]" style="background-color: #181d1f !important;">
                <option value="">Toutes les journées</option>
                <?php $__currentLoopData = $rencontres->pluck('journee')->unique()->sort(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($j); ?>" <?php if(request('journee') == $j): ?> selected <?php endif; ?> style="background-color: #181d1f; color: #6fcf97;">Journée <?php echo e($j); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="saison_id" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] font-semibold focus:ring-2 focus:ring-[#6fcf97]" style="background-color: #181d1f !important;">
                <option value="">Toutes les saisons</option>
                <?php $__currentLoopData = $saisons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>" <?php if(request('saison_id') == $s->id): ?> selected <?php endif; ?> style="background-color: #181d1f; color: #6fcf97;"><?php echo e($s->nom); ?></option>
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
    <div class="space-y-4">
        <div class="hidden md:grid grid-cols-8 gap-4 px-6 py-2 text-[#6fcf97] font-bold uppercase text-xs tracking-wider">
            <div>Date</div>
            <div>Equipe 1</div>
            <div></div>
            <div>Equipe 2</div>
            <div>Heure</div>
            <div>Score</div>
            <div>MVP</div>
            <div>Pool</div>
        </div>
        <?php $__currentLoopData = $rencontres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(url('/matchs/' . $match->id)); ?>" class="block group">
            <div class="grid grid-cols-1 md:grid-cols-8 items-center bg-[#181d1f] rounded-lg shadow px-6 py-4 border-l-4 border-[#6fcf97] gap-2 md:gap-4 transition duration-200 group-hover:bg-[#23272a] group-hover:shadow-lg group-hover:border-[#e2001a] cursor-pointer">
                <div class="text-gray-400 text-xs font-bold uppercase">
                    <?php echo e(\Carbon\Carbon::parse($match->date)->locale('fr')->translatedFormat('l d F')); ?>

                </div>
                <div class="flex items-center gap-2">
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
                    <span class="font-extrabold text-white text-lg"><?php echo e($match->equipe1->nom); ?></span>
                </div>
                <span class="font-extrabold text-white text-lg text-center">VS</span>
                <div class="flex items-center gap-2">
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
                    <span class="font-extrabold text-white text-lg"><?php echo e($match->equipe2->nom); ?></span>
                </div>
                <div class="text-white font-bold text-lg"><?php echo e($match->heure ?? '--:--'); ?></div>
                <div>
                    <?php if(isset($match->statut) && $match->statut === 'joue'): ?>
                        <span class="text-white font-bold"><?php echo e($match->score ?? '-'); ?></span>
                    <?php else: ?>
                        <span class="text-gray-500">-</span>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if(isset($match->statut) && $match->statut === 'joue'): ?>
                        <span class="text-white font-bold"><?php echo e($match->mvp?->nom ?? '-'); ?></span>
                    <?php else: ?>
                        <span class="text-gray-500">-</span>
                    <?php endif; ?>
                </div>
                <div class="text-[#e2001a] font-bold text-xs uppercase">
                    <?php if($match->pool): ?>
                        <?php echo e(strtoupper($match->pool->nom)); ?>

                    <?php elseif($match->type_rencontre === 'amical' || $match->type_rencontre === 'externe'): ?>
                        AMICAL
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </div>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="flex justify-center mt-8">
        <?php
            $nextJournee = $rencontres->pluck('journee')->unique()->sort()->filter(fn($j) => $j > request('journee', 1))->first();
        ?>
        <?php if($nextJournee): ?>
        <a href="?journee=<?php echo e($nextJournee); ?>&saison_id=<?php echo e(request('saison_id', $saisons->first()?->id)); ?>" class="px-8 py-3 bg-[#23272a] border-2 border-[#6fcf97] text-white font-bold rounded hover:bg-[#6fcf97] hover:text-[#23272a] transition">MATCHDAY <?php echo e($nextJournee); ?></a>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/public/matchs.blade.php ENDPATH**/ ?>