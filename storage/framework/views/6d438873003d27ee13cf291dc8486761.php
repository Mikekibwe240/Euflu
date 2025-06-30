
<?php $__env->startSection('title', 'Classement Bundesliga Style'); ?>
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
    <?php
        use App\Models\Saison;
        $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        $selectedSaison = request('saison_id') ? \App\Models\Saison::find(request('saison_id')) : ($saison ?? null);
        $poules = $selectedSaison ? $selectedSaison->pools()->with(['equipes', 'equipes.statsSaison'])->get() : collect();
        $selectedPoule = request('poule');
    ?>
    <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-8 gap-4">
        <div>
            <div class="text-4xl font-extrabold text-white uppercase tracking-wider mb-2">CLASSEMENT</div>
            <div class="text-base text-gray-400 font-semibold uppercase">Tableau complet</div>
        </div>
        <form method="GET" action="" class="flex items-center gap-4 px-4 py-3 rounded-lg bg-[#181d1f] border border-[#31363a] shadow-md">
            <label for="saison_id" class="text-gray-200 font-bold uppercase tracking-wide mr-2">Saison</label>
            <select name="saison_id" id="saison_id" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] focus:outline-none focus:ring-2 focus:ring-[#e2001a] font-semibold shadow-sm transition placeholder-gray-400">
                <?php $__currentLoopData = \App\Models\Saison::orderByDesc('date_debut')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>" <?php if(request('saison_id', $saison?->id) == $s->id): ?> selected <?php endif; ?> style="color:#23272a; background:#fff; font-weight:bold;"><?php echo e($s->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="ml-2 px-5 py-2 bg-gradient-to-r from-[#e2001a] to-[#b80016] text-white font-extrabold rounded shadow-lg hover:from-[#b80016] hover:to-[#e2001a] focus:outline-none focus:ring-2 focus:ring-[#6fcf97] transition">OK</button>
        </form>
    </div>
    <?php if($selectedSaison && $poules->count()): ?>
        <?php $__currentLoopData = $poules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $poule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-8" <?php if($selectedPoule && $selectedPoule == $poule->nom): ?> id="selected-poule" <?php endif; ?>>
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-[#e2001a] font-extrabold text-lg uppercase tracking-wider">Classement</span>
                    <span class="text-gray-400 font-bold uppercase text-xs"><?php echo e($poule->nom); ?></span>
                </div>
                <div class="overflow-x-auto rounded-lg shadow" style="background:#181d1f;">
                    <table class="min-w-full bg-[#23272a] text-white text-base bundesliga-table" style="border-radius:0;">
                        <thead class="bg-transparent text-white uppercase text-base">
                            <tr>
                                <th class="px-4 py-3 text-left font-extrabold" style="font-size:2rem;">#</th>
                                <th class="px-4 py-3 text-left font-extrabold" style="font-size:2rem;">Équipe</th>
                                <th class="px-4 py-3 text-center font-extrabold">MJ</th>
                                <th class="px-4 py-3 text-center font-extrabold">V</th>
                                <th class="px-4 py-3 text-center font-extrabold">N</th>
                                <th class="px-4 py-3 text-center font-extrabold">D</th>
                                <th class="px-4 py-3 text-center font-extrabold">B</th>
                                <th class="px-4 py-3 text-center font-extrabold">+/-</th>
                                <th class="px-4 py-3 text-center font-extrabold">Pts</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $classement = $poule->equipes->map(function($eq) use ($selectedSaison) {
                                $stats = $eq->statsSaison($selectedSaison->id)->first();
                                return (object) [
                                    'equipe' => $eq,
                                    'mj' => ($stats?->victoires ?? 0) + ($stats?->nuls ?? 0) + ($stats?->defaites ?? 0),
                                    'mg' => $stats?->victoires ?? 0,
                                    'mp' => $stats?->defaites ?? 0,
                                    'mn' => $stats?->nuls ?? 0,
                                    'bp' => $stats?->buts_pour ?? 0,
                                    'bc' => $stats?->buts_contre ?? 0,
                                    'gd' => ($stats?->buts_pour ?? 0) - ($stats?->buts_contre ?? 0),
                                    'points' => $stats?->points ?? 0,
                                ];
                            })->sortByDesc('points')->sortByDesc('gd')->sortByDesc('bp')->values();
                        ?>
                        <?php $__currentLoopData = $classement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-[#333] hover:bg-[#e2001a]/10 transition" style="font-size:1.15rem; cursor:pointer;" onclick="window.location='<?php echo e(route('equipes.show', ['equipe' => $row->equipe->id])); ?>'">
                                <td class="px-4 py-3 font-extrabold text-white"><?php echo e($i+1); ?></td>
                                <td class="px-4 py-3 flex items-center gap-2 font-extrabold">
                                    <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $row->equipe,'size' => 32]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row->equipe),'size' => 32]); ?>
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
                                    <span><?php echo e($row->equipe->nom); ?></span>
                                </td>
                                <td class="px-4 py-3 text-center"><?php echo e($row->mj); ?></td>
                                <td class="px-4 py-3 text-center"><?php echo e($row->mg); ?></td>
                                <td class="px-4 py-3 text-center"><?php echo e($row->mn); ?></td>
                                <td class="px-4 py-3 text-center"><?php echo e($row->mp); ?></td>
                                <td class="px-4 py-3 text-center"><?php echo e($row->bp); ?>:<?php echo e($row->bc); ?></td>
                                <td class="px-4 py-3 text-center font-bold" style="color:<?php echo e($row->gd > 0 ? '#6fcf97' : ($row->gd < 0 ? '#e2001a' : '#fff')); ?>;"><?php echo e($row->gd > 0 ? '+' : ''); ?><?php echo e($row->gd); ?></td>
                                <td class="px-4 py-3 text-center font-extrabold text-white"><?php echo e($row->points); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($selectedPoule): ?>
        <script>
            // Scroll to the selected pool if present
            window.onload = function() {
                var el = document.getElementById('selected-poule');
                if(el) el.scrollIntoView({behavior: 'smooth', block: 'start'});
            };
        </script>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/public/classement.blade.php ENDPATH**/ ?>