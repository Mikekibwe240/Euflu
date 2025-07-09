

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('header'); ?>
    Tableau de bord
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-bl-card rounded-lg shadow p-6 flex flex-col items-center border border-bl-border">
        <div class="text-bl-gray text-sm">Saisons actives</div>
        <div class="text-3xl font-bold text-white mt-2"><?php echo e($saisonsActives ?? 0); ?></div>
    </div>
    <div class="bg-bl-card rounded-lg shadow p-6 flex flex-col items-center border border-bl-border">
        <div class="text-bl-gray text-sm">Équipes</div>
        <div class="text-3xl font-bold text-green-500 mt-2"><?php echo e($equipes ?? 0); ?></div>
    </div>
    <div class="bg-bl-card rounded-lg shadow p-6 flex flex-col items-center border border-bl-border">
        <div class="text-bl-gray text-sm">Joueurs</div>
        <div class="text-3xl font-bold text-white mt-2"><?php echo e($joueurs ?? 0); ?></div>
    </div>
    <div class="bg-bl-card rounded-lg shadow p-6 flex flex-col items-center border border-bl-border">
        <div class="text-bl-gray text-sm">Utilisateurs</div>
        <div class="text-3xl font-bold text-white mt-2"><?php echo e($users ?? 0); ?></div>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-bl-card rounded-lg shadow p-6 flex flex-col items-center border border-bl-border">
        <div class="text-bl-gray text-sm">Articles publiés</div>
        <div class="text-3xl font-bold text-pink-700 dark:text-pink-300 mt-2"><?php echo e($articles ?? 0); ?></div>
    </div>
    <div class="bg-bl-card rounded-lg shadow p-6 flex flex-col items-center border border-bl-border">
        <div class="text-bl-gray text-sm">Matchs</div>
        <div class="text-3xl font-bold text-indigo-700 dark:text-indigo-300 mt-2"><?php echo e($matchs ?? 0); ?></div>
    </div>
    <div class="bg-bl-card rounded-lg shadow p-6 flex flex-col items-center border border-bl-border">
        <div class="text-bl-gray text-sm">Buts marqués</div>
        <div class="text-3xl font-bold text-white mt-2"><?php echo e($buts ?? 0); ?></div>
    </div>
    <div class="bg-bl-card rounded-lg shadow p-6 flex flex-col items-center border border-bl-border">
        <div class="text-bl-gray text-sm">Cartons</div>
        <div class="text-3xl font-bold text-orange-700 dark:text-orange-300 mt-2"><?php echo e($cartons ?? 0); ?></div>
    </div>
</div>
<div class="mt-8">
    <h2 class="text-lg font-extrabold text-white mb-4 tracking-widest">Bienvenue sur le tableau de bord administrateur !</h2>
    <p class="text-bl-gray mb-8">Utilisez le menu à gauche pour gérer les saisons, équipes, joueurs, matchs, articles et règlements.</p>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
        <a href="<?php echo e(route('admin.joueurs.index')); ?>" class="bg-bl-accent text-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-bl-dark hover:text-bl-accent border border-bl-accent transition">
            <span class="text-3xl mb-2">👤</span>
            <span class="font-bold text-lg">Gérer les joueurs</span>
        </a>
        <a href="<?php echo e(route('admin.equipes.index')); ?>" class="bg-green-700 text-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-bl-dark hover:text-green-400 border border-green-700 transition">
            <span class="text-3xl mb-2">⚽</span>
            <span class="font-bold text-lg">Gérer les équipes</span>
        </a>
        <a href="<?php echo e(route('admin.rencontres.index')); ?>" class="bg-bl-card text-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-bl-accent hover:text-white border border-bl-border transition">
            <span class="text-3xl mb-2">📅</span>
            <span class="font-bold text-lg">Voir les matchs</span>
        </a>
        <a href="<?php echo e(route('admin.articles.index')); ?>" class="bg-bl-card text-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-bl-accent hover:text-white border border-bl-border transition">
            <span class="text-3xl mb-2">📰</span>
            <span class="font-bold text-lg">Articles</span>
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <?php $__currentLoopData = $poules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $poule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-50 dark:bg-gray-900 rounded-xl shadow p-6 flex flex-col items-center gap-4">
                
                
                
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php echo $__env->make('admin.dashboard_graphs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>