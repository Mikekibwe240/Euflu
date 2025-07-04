<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'article',
    'excerptLength' => 120,
    'showExcerpt' => true,
    'imgHeight' => 'h-48',
    'rounded' => '', // pas d'arrondi
    'shadow' => '', // pas d'ombre
    'border' => '', // pas de bordure sur la card principale
    'class' => ''
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'article',
    'excerptLength' => 120,
    'showExcerpt' => true,
    'imgHeight' => 'h-48',
    'rounded' => '', // pas d'arrondi
    'shadow' => '', // pas d'ombre
    'border' => '', // pas de bordure sur la card principale
    'class' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<div class="bg-[#23272a] p-0 flex flex-col overflow-hidden <?php echo e($class); ?> cursor-pointer group" onclick="window.location='<?php echo e(route('public.articles.show', $article->id)); ?>'">
    <?php
        $imgCount = $article->images?->count() ?? 0;
        $img = $article->images->first() ?? null;
        $hasVideo = $article->video;
    ?>
    <?php if($hasVideo): ?>
        <div class="w-full <?php echo e($imgHeight); ?> relative" id="carousel-card-<?php echo e($article->id); ?>">
            <video controls class="w-full h-full object-cover bg-black" style="min-height:120px;" onclick="event.stopPropagation();openMediaModal('video', `<?php echo e(asset('storage/' . $article->video)); ?>`)">
                <source src="<?php echo e(asset('storage/' . $article->video)); ?>" type="video/mp4">
                Votre navigateur ne supporte pas la lecture vidéo.
            </video>
        </div>
    <?php elseif($imgCount > 1): ?>
        <div id="carousel-card-<?php echo e($article->id); ?>" class="relative w-full <?php echo e($imgHeight); ?> group" data-carousel>
            <div class="overflow-hidden w-full h-full relative">
                <?php $__currentLoopData = $article->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <img src="<?php echo e(asset('storage/' . $img->path)); ?>" alt="Image article" class="w-full h-full object-cover absolute inset-0 transition-all duration-700 ease-in-out <?php echo e($imgHeight); ?> <?php echo e($i === 0 ? '' : 'hidden'); ?> cursor-pointer" data-carousel-item onclick="event.stopPropagation();openMediaModal('image', `<?php echo e(asset('storage/' . $img->path)); ?>`)" />
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <button type="button" aria-label="Précédent" class="absolute top-1/2 left-2 -translate-y-1/2 bg-white/90 hover:bg-blue-100 rounded-full p-1 shadow opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10" data-carousel-prev onclick="event.stopPropagation();">
                <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            </button>
            <button type="button" aria-label="Suivant" class="absolute top-1/2 right-2 -translate-y-1/2 bg-white/90 hover:bg-blue-100 rounded-full p-1 shadow opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10" data-carousel-next onclick="event.stopPropagation();">
                <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </button>
            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1 z-10">
                <?php $__currentLoopData = $article->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button type="button" aria-label="Aller à l'image <?php echo e($i+1); ?>" class="w-2 h-2 rounded-full border-2 border-blue-400 bg-white transition-all duration-300" style="opacity: <?php echo e($i === 0 ? '1' : '0.5'); ?>;" data-carousel-indicator onclick="event.stopPropagation();"></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php elseif($img): ?>
        <div class="w-full <?php echo e($imgHeight); ?> relative">
            <img src="<?php echo e(asset('storage/' . $img->path)); ?>" alt="Image article" class="w-full h-full object-cover" style="min-height:120px;" onerror="this.style.display='none'" onclick="event.stopPropagation();openMediaModal('image', `<?php echo e(asset('storage/' . $img->path)); ?>`)" />
        </div>
    <?php else: ?>
        <div class="flex items-center justify-center w-full <?php echo e($imgHeight); ?> bg-[#23272a] text-[#e2001a] text-5xl font-extrabold select-none" style="min-height:120px;">
            <?php echo e(mb_substr($article->titre,0,1)); ?>

        </div>
    <?php endif; ?>
    <div class="flex flex-col flex-1 p-4">
        <h2 class="text-lg font-extrabold mb-1 text-white line-clamp-2 leading-tight"><?php echo e($article->titre); ?></h2>
        <div class="text-xs text-[#6fcf97] font-semibold mb-2 uppercase tracking-wider"><?php echo e($article->type ?? 'Article'); ?> • <?php echo e($article->saison->nom ?? '-'); ?></div>
        <?php if($showExcerpt): ?>
            <div class="mb-2 text-gray-300 text-sm line-clamp-3"><?php echo Str::limit(strip_tags($article->contenu), $excerptLength); ?></div>
        <?php endif; ?>
        <div class="mt-auto flex justify-between items-end pt-2">
            <a href="<?php echo e(route('public.articles.show', $article->id)); ?>" class="text-[#e2001a] font-bold hover:underline text-sm" onclick="event.stopPropagation();">Lire la suite</a>
            <span class="text-xs text-gray-500">par <?php echo e($article->user->name ?? '-'); ?></span>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/components/article-card.blade.php ENDPATH**/ ?>