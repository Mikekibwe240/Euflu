

<?php $__env->startSection('title', 'Fiche Article'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-bl-card rounded-2xl shadow-xl p-8 border border-bl-border">
        <div class="mb-4 flex items-center gap-4">
            <span class="inline-block bg-bl-accent text-white rounded-full px-4 py-1 font-bold text-lg shadow">N° <?php echo e($article->id); ?></span>
            <h1 class="text-3xl font-extrabold text-white"><?php echo e($article->titre); ?></h1>
        </div>
        <div class="mb-2 text-gray-400 text-sm flex flex-wrap gap-2 items-center">
            <span class="bg-bl-card border border-bl-border text-white px-2 py-1 rounded text-xs font-semibold">Saison : <?php echo e($article->saison->nom ?? $article->saison->annee ?? '-'); ?></span>
            <span class="bg-bl-card border border-bl-border text-gray-200 px-2 py-1 rounded text-xs">Auteur : <?php echo e($article->user->name ?? '-'); ?></span>
            <span class="bg-bl-card border border-bl-border text-green-400 px-2 py-1 rounded text-xs">Publié le : <?php echo e($article->created_at->format('d/m/Y')); ?></span>
        </div>
        <hr class="my-4 border-bl-border">
        <div class="prose dark:prose-invert max-w-none mb-4 text-lg leading-relaxed text-white">
            <?php echo nl2br(e($article->contenu)); ?>

        </div>
        <?php $imgCount = $article->images?->count() ?? 0; ?>
        <?php if($article->video || ($article->images && $article->images->count())): ?>
        <div class="mb-6">
            <div data-carousel class="relative w-full max-w-xl mx-auto rounded-xl overflow-hidden shadow bg-black">
                <?php if($article->video): ?>
                    <div data-carousel-item class="w-full h-80 md:h-[28rem]">
                        <video src="<?php echo e(asset('storage/' . $article->video)); ?>" class="w-full h-80 md:h-[28rem] object-cover object-center rounded-xl" autoplay muted loop playsinline controls></video>
                    </div>
                <?php endif; ?>
                <?php $__currentLoopData = $article->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div data-carousel-item class="w-full h-80 md:h-[28rem]">
                        <img src="<?php echo e(asset('storage/' . $img->path)); ?>" class="w-full h-80 md:h-[28rem] object-cover object-center rounded-xl" />
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <button type="button" data-carousel-prev class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-bl-accent/80 rounded-full p-2 shadow z-10 text-2xl">&#8249;</button>
                <button type="button" data-carousel-next class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-bl-accent/80 rounded-full p-2 shadow z-10 text-2xl">&#8250;</button>
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    <?php if($article->video): ?>
                        <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-bl-accent bg-white transition-all duration-300 opacity-100"></button>
                    <?php endif; ?>
                    <?php $__currentLoopData = $article->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-bl-accent bg-white transition-all duration-300 opacity-50"></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="flex gap-2 mb-6">
            <a href="<?php echo e(route('admin.articles.edit', $article)); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow border border-yellow-500 transition">Modifier</a>
            <form action="<?php echo e(route('admin.articles.destroy', $article)); ?>" method="POST" onsubmit="return confirm('Supprimer définitivement cet article ?');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">Supprimer</button>
            </form>
            <a href="<?php echo e(route('admin.articles.index')); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow border border-yellow-500 ml-auto transition">← Retour à la liste</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/articles/show.blade.php ENDPATH**/ ?>