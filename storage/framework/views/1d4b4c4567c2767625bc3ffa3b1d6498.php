
<?php $__env->startSection('title', 'Actualités Bundesliga Style'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $featured = $articles->first();
    $others = $articles->slice(1);
?>
<?php if($featured): ?>
    <div class="max-w-6xl mx-auto mt-6 mb-10">
        <div class="relative rounded-lg overflow-hidden shadow-lg">
            <?php if(($featured->images && $featured->images->count()) || $featured->video): ?>
                <div data-carousel class="relative w-full h-72">
                    <?php if($featured->video): ?>
                        <div data-carousel-item class="w-full h-72">
                            <video src="<?php echo e(asset('storage/' . $featured->video)); ?>" class="w-full h-72 object-cover object-center rounded" autoplay muted loop playsinline></video>
                        </div>
                    <?php endif; ?>
                    <?php $__currentLoopData = $featured->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div data-carousel-item class="w-full h-72">
                            <img src="<?php echo e(asset('storage/' . $img->path)); ?>" alt="Image principale" class="w-full h-72 object-cover object-center rounded" />
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <button type="button" data-carousel-prev class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10">‹</button>
                    <button type="button" data-carousel-next class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10">›</button>
                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                        <?php if($featured->video): ?>
                            <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-blue-400 bg-white transition-all duration-300 opacity-100"></button>
                        <?php endif; ?>
                        <?php $__currentLoopData = $featured->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-blue-400 bg-white transition-all duration-300 opacity-50"></button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-transparent p-6">
                <div class="text-xs text-[#e2001a] font-bold uppercase mb-1"><?php echo e(strtoupper($featured->type ?? 'ACTUALITÉ')); ?> <span class="ml-2 text-gray-300 font-normal"><?php echo e($featured->created_at->format('M d, Y')); ?></span></div>
                <a href="<?php echo e(route('public.articles.show', $featured->id)); ?>" class="block">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 leading-tight"><?php echo e($featured->titre); ?></h1>
                </a>
                <div class="text-white text-base font-medium mb-2 line-clamp-3"><?php echo e(Str::limit(strip_tags($featured->contenu), 200)); ?></div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="max-w-6xl mx-auto mb-10">
    <h2 class="text-2xl font-extrabold text-white uppercase tracking-wider mb-6 mt-8">PLUS D'ACTUALITÉS</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php $__currentLoopData = $others; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex flex-col md:flex-row bg-[#181d1f] rounded-lg shadow-lg overflow-hidden border border-[#23272a]">
                <?php if(($article->images && $article->images->count()) || $article->video): ?>
                    <div class="md:w-1/3 w-full h-48 md:h-auto flex-shrink-0 relative">
                        <div data-carousel class="relative w-full h-48 md:h-64">
                            <?php if($article->video): ?>
                                <div data-carousel-item class="w-full h-48 md:h-64">
                                    <video src="<?php echo e(asset('storage/' . $article->video)); ?>" class="w-full h-48 md:h-64 object-cover object-center rounded" autoplay muted loop playsinline></video>
                                </div>
                            <?php endif; ?>
                            <?php $__currentLoopData = $article->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div data-carousel-item class="w-full h-48 md:h-64">
                                    <img src="<?php echo e(asset('storage/' . $img->path)); ?>" alt="Image article" class="w-full h-48 md:h-64 object-cover object-center rounded" />
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" data-carousel-prev class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10">‹</button>
                            <button type="button" data-carousel-next class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10">›</button>
                            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                                <?php if($article->video): ?>
                                    <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-blue-400 bg-white transition-all duration-300 opacity-100"></button>
                                <?php endif; ?>
                                <?php $__currentLoopData = $article->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-blue-400 bg-white transition-all duration-300 opacity-50"></button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="flex-1 p-6 flex flex-col justify-between">
                    <div>
                        <div class="text-xs text-[#e2001a] font-bold uppercase mb-1"><?php echo e(strtoupper($article->type ?? 'ACTUALITÉ')); ?> <span class="ml-2 text-gray-400 font-normal"><?php echo e($article->created_at->format('M d, Y')); ?></span></div>
                        <a href="<?php echo e(route('public.articles.show', $article->id)); ?>">
                            <h3 class="text-xl font-bold text-white mb-2 leading-tight hover:text-[#e2001a]"><?php echo e($article->titre); ?></h3>
                        </a>
                        <div class="text-gray-300 text-sm mb-2 line-clamp-3"><?php echo e(Str::limit(strip_tags($article->contenu), 120)); ?></div>
                    </div>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-xs text-gray-400"><?php echo e($article->user->name ?? ''); ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="mt-8">
        <?php echo e($articles->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-carousel]')?.forEach(function(carousel) {
        let slides = carousel.querySelectorAll('[data-carousel-item]');
        let indicators = carousel.querySelectorAll('[data-carousel-indicator]');
        let current = 0;
        let interval = null;
        function showSlide(idx) {
            slides.forEach((el, i) => {
                el.classList.toggle('hidden', i !== idx);
                if (indicators[i]) indicators[i].style.opacity = (i === idx ? '1' : '0.5');
            });
            current = idx;
        }
        function nextSlide() {
            showSlide((current + 1) % slides.length);
        }
        function prevSlide() {
            showSlide((current - 1 + slides.length) % slides.length);
        }
        indicators.forEach((btn, i) => {
            btn.addEventListener('click', () => showSlide(i));
        });
        carousel.querySelector('[data-carousel-next]')?.addEventListener('click', nextSlide);
        carousel.querySelector('[data-carousel-prev]')?.addEventListener('click', prevSlide);
        showSlide(0);
        interval = setInterval(nextSlide, 5000);
        carousel.addEventListener('mouseenter', () => clearInterval(interval));
        carousel.addEventListener('mouseleave', () => interval = setInterval(nextSlide, 5000));
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/public/articles.blade.php ENDPATH**/ ?>