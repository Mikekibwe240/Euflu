

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('header'); ?>
    Tableau de bord
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Saisons actives</div>
        <div class="text-3xl font-bold text-blue-700 dark:text-blue-300 mt-2"><?php echo e($saisonsActives ?? 0); ?></div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Équipes</div>
        <div class="text-3xl font-bold text-green-700 dark:text-green-300 mt-2"><?php echo e($equipes ?? 0); ?></div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Joueurs</div>
        <div class="text-3xl font-bold text-yellow-700 dark:text-yellow-300 mt-2"><?php echo e($joueurs ?? 0); ?></div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Utilisateurs</div>
        <div class="text-3xl font-bold text-purple-700 dark:text-purple-300 mt-2"><?php echo e($users ?? 0); ?></div>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Articles publiés</div>
        <div class="text-3xl font-bold text-pink-700 dark:text-pink-300 mt-2"><?php echo e($articles ?? 0); ?></div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Matchs</div>
        <div class="text-3xl font-bold text-indigo-700 dark:text-indigo-300 mt-2"><?php echo e($matchs ?? 0); ?></div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Buts marqués</div>
        <div class="text-3xl font-bold text-red-700 dark:text-red-300 mt-2"><?php echo e($buts ?? 0); ?></div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center">
        <div class="text-gray-500 dark:text-gray-300 text-sm">Cartons</div>
        <div class="text-3xl font-bold text-orange-700 dark:text-orange-300 mt-2"><?php echo e($cartons ?? 0); ?></div>
    </div>
</div>
<div class="mt-8">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Bienvenue sur le tableau de bord administrateur !</h2>
    <p class="text-gray-600 dark:text-gray-300 mb-8">Utilisez le menu à gauche pour gérer les saisons, équipes, joueurs, matchs, articles et règlements.</p>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
        <a href="<?php echo e(route('admin.joueurs.index')); ?>" class="bg-blue-600 text-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-blue-700 transition">
            <span class="text-3xl mb-2">👤</span>
            <span class="font-bold text-lg">Gérer les joueurs</span>
        </a>
        <a href="<?php echo e(route('admin.equipes.index')); ?>" class="bg-green-600 text-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-green-700 transition">
            <span class="text-3xl mb-2">⚽</span>
            <span class="font-bold text-lg">Gérer les équipes</span>
        </a>
        <a href="<?php echo e(route('admin.rencontres.index')); ?>" class="bg-indigo-600 text-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-indigo-700 transition">
            <span class="text-3xl mb-2">📅</span>
            <span class="font-bold text-lg">Voir les matchs</span>
        </a>
        <a href="<?php echo e(route('admin.articles.index')); ?>" class="bg-pink-600 text-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-pink-700 transition">
            <span class="text-3xl mb-2">📰</span>
            <span class="font-bold text-lg">Articles</span>
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <?php $__currentLoopData = $poules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $poule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-50 dark:bg-gray-900 rounded-xl shadow p-6 flex flex-col items-center gap-4">
                <div class="text-lg font-bold text-blue-700 dark:text-blue-300 mb-2">Poule <?php echo e($poule->nom); ?></div>
                <a href="<?php echo e(route('admin.classement', ['poule' => $poule->id])); ?>" class="w-full bg-blue-600 text-white rounded-lg shadow px-4 py-2 text-center font-semibold hover:bg-blue-700 transition">Classement équipes</a>
                <a href="<?php echo e(route('admin.classement_buteurs', ['pool' => $poule->id])); ?>" class="w-full bg-yellow-500 text-white rounded-lg shadow px-4 py-2 text-center font-semibold hover:bg-yellow-600 transition">Classement buteurs</a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php echo $__env->make('admin.dashboard_graphs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>