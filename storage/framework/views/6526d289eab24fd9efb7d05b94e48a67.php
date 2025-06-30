<?php $__env->startSection('title', 'Accueil Bundesliga Style'); ?>

<?php $__env->startSection('header'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('header'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
    use App\Models\Article;
    use Illuminate\Support\Str;
    use App\Models\Saison;
    use App\Models\Pool;
    $article = Article::orderByDesc('published_at')->first();
    $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
    $poules = $saison ? $saison->pools()->with(['equipes', 'equipes.statsSaison' => function($q) use ($saison) { $q->where('saison_id', $saison->id); }])->get() : collect();
    $sponsors = [
        '4201730-removebg-preview.png',
        'equity-bank-logo.png',
        'lubumbasi.png',
        'ministre_des_hydrocarbures_cover.jpeg',
        'rawbank.webp',
    ];

    // Fonction d'abréviation inspirée du composant TeamLogo
    function makeAbbreviation($name) {
        $words = preg_split('/\s+/', trim($name));
        if (count($words) === 1) {
            return strtoupper(mb_substr($words[0], 0, 3));
        }
        $abbr = '';
        foreach ($words as $w) {
            $abbr .= mb_substr($w, 0, 1);
        }
        return strtoupper(mb_substr($abbr, 0, 3));
    }
?>
<div class="w-full bg-[#10181c] min-h-screen pb-12">
    <div class="max-w-6xl mx-auto">
        <!-- HERO SECTION -->
        <div class="w-full aspect-[2.3/1] bg-[#23272a] rounded-none overflow-hidden relative mt-0 mb-8 shadow-none">
            <?php
                $media = $article && $article->media ? $article->media : null;
                $isVideo = $media && preg_match('/\.(mp4|webm|ogg)$/i', $media);
                $mediaUrl = $media ? asset('storage/' . $media) : null;
            ?>
            <?php if($media): ?>
                <div class="text-xs text-yellow-400 bg-black/60 p-2 absolute z-50">MEDIA: <?php echo e($media); ?><br>URL: <a href="<?php echo e($mediaUrl); ?>" target="_blank" class="underline"><?php echo e($mediaUrl); ?></a></div>
            <?php endif; ?>
            <?php if($media && $isVideo): ?>
                <video class="w-full h-full object-cover object-center" controls poster="https://placehold.co/1200x520?text=EUFLU">
                    <source src="<?php echo e($mediaUrl); ?>">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
            <?php elseif($media && !$isVideo): ?>
                <img src="<?php echo e($mediaUrl); ?>" alt="Image à la une" class="w-full h-full object-cover object-center">
            <?php else: ?>
                <img src="https://placehold.co/1200x520?text=EUFLU" alt="Image à la une" class="w-full h-full object-cover object-center">
            <?php endif; ?>
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 to-transparent p-8">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-2 uppercase leading-tight"><?php echo e($article ? $article->titre : 'Aucune actualité'); ?></h2>
                <p class="text-white text-lg font-medium max-w-2xl"><?php echo $article ? Str::limit(strip_tags($article->contenu), 140) : ''; ?></p>
                <div class="text-gray-400 text-xs mt-2"><?php echo e($article && $article->published_at ? \Illuminate\Support\Carbon::parse($article->published_at)->format('d.m.Y') : ''); ?></div>
            </div>
        </div>
        <!-- PARTNERS SECTION -->
        <div class="w-full bg-[#23272a] border-t border-[#31363a] px-0 py-8 mb-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-base text-gray-300 font-light tracking-widest uppercase text-left mb-6 pl-2 md:pl-4" style="letter-spacing:0.08em;">
                    PARTENAIRES OFFICIELS DE L'EUFLU <span class="font-bold text-white">PARTENAIRES</span>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-x-16 gap-y-8 mt-2">
                    <?php $__currentLoopData = $sponsors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sponsor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/img_euflu/sponsors/' . $sponsor)); ?>" alt="Sponsor" class="h-14 max-w-[140px] object-contain grayscale-0" loading="lazy">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <!-- TABLE SECTION -->
        <?php if($saison && $poules->count()): ?>
            <div class="w-full mb-8">
                <div class="text-2xl font-extrabold text-white tracking-widest mb-8 uppercase text-center" style="letter-spacing:0.08em;">
                    CLASSEMENTS
                </div>
                <?php $__currentLoopData = $poules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $poule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-8">
                        <div class="text-base font-extrabold text-white tracking-widest mb-2 uppercase flex items-center gap-2 pl-4">
                            <span class="text-[#e2001a]">POOL <?php echo e(strtoupper($poule->nom)); ?></span>
                        </div>
                        <div class="relative">
                            <div class="flex flex-nowrap overflow-x-auto gap-6 py-6 px-0 bg-[#181d1f] border-t-4 border-[#23272a]" style="border-radius:0;">
                                <?php
                                    $classement = $poule->equipes->map(function($eq) use ($saison) {
                                        $stats = $eq->statsSaison($saison->id)->first();
                                        return (object) [
                                            'equipe' => $eq,
                                            'points' => $stats?->points ?? 0,
                                        ];
                                    })->sortByDesc('points')->values();
                                ?>
                                <?php $__currentLoopData = $classement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex flex-col items-center justify-center min-w-[110px] max-w-[110px] h-[240px] bg-[#23272a] text-center relative shadow-md border border-[#23282d]" style="border-radius:0; flex: 0 0 110px;">
                                        <div class="text-lg text-gray-400 font-bold mb-2 mt-4"><?php echo e($i+1); ?>.</div>
                                        <div class="flex items-center justify-center h-16 mb-4">
                                            <?php if (isset($component)) { $__componentOriginal5564dd85bf2706938f671f4ed6c78011 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5564dd85bf2706938f671f4ed6c78011 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.team-logo','data' => ['team' => $row->equipe,'size' => 48]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('team-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['team' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row->equipe),'size' => 48]); ?>
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
                                        <div class="font-extrabold text-xl uppercase text-white mb-2"><?php echo e($row->equipe->abbreviation ?? makeAbbreviation($row->equipe->nom)); ?></div>
                                        <div class="text-base text-gray-400 font-bold"><?php echo e($row->points); ?>Pts</div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="flex justify-end mt-4 pr-4">
                                <a href="/classement?poule=<?php echo e(urlencode($poule->nom)); ?>" class="font-extrabold uppercase text-lg tracking-wider transition px-6 py-2 rounded shadow" style="color:#e2001a; border:none; background:transparent;" onmouseover="this.style.color='#b80015'" onmouseout="this.style.color='#e2001a'">VIEW FULL TABLE &rarr;</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/welcome.blade.php ENDPATH**/ ?>