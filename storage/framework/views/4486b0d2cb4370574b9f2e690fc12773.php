

<?php $__env->startSection('title', isset($top) && $top === 'buteurs' ? 'Classement des buteurs' : 'Recherche de joueur'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-center text-blue-700 dark:text-blue-300">
        <?php echo e(isset($top) && $top === 'buteurs' ? 'Classement des buteurs' : 'Joueurs'); ?>

    </h1>
    <form method="GET" action="<?php echo e(route('public.joueurs.search')); ?>" class="flex flex-wrap gap-4 justify-center mb-8 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Nom ou prénom..." class="w-56 px-4 py-2 rounded border border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:text-white">
        <select name="equipe_id" class="w-48 px-2 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
            <option value="">Toutes les équipes</option>
            <?php $__currentLoopData = \App\Models\Equipe::orderBy('nom')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($equipe->id); ?>" <?php echo e(request('equipe_id') == $equipe->id ? 'selected' : ''); ?>><?php echo e($equipe->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="poste" class="w-40 px-2 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
            <option value="">Tous les postes</option>
            <?php $__currentLoopData = \App\Models\Joueur::select('poste')->distinct()->pluck('poste'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $poste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($poste); ?>" <?php echo e(request('poste') == $poste ? 'selected' : ''); ?>><?php echo e($poste); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php if(isset($top) && $top === 'buteurs'): ?>
            <span class="bg-green-100 text-green-700 px-6 py-2 rounded font-semibold ring-2 ring-green-400">Classement buteurs</span>
        <?php else: ?>
            <a href="<?php echo e(route('public.joueurs.search', array_merge(request()->except('top'), ['top' => 'buteurs']))); ?>" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">Classement buteurs</a>
        <?php endif; ?>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Filtrer</button>
    </form>
    <?php if(isset($top) && $top === 'buteurs' && isset($pools)): ?>
        <?php $__currentLoopData = $pools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 overflow-x-auto mb-8">
                <h2 class="text-xl font-bold mb-4 text-blue-700 dark:text-blue-300">Classement des buteurs - Pool <?php echo e($pool->nom); ?></h2>
                <?php $poolJoueurs = $joueurs[$pool->nom] ?? collect(); ?>
                <?php if($poolJoueurs->isEmpty()): ?>
                    <p class="text-center text-gray-500">Aucun buteur trouvé pour ce pool.</p>
                <?php else: ?>
                <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow table-fixed">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="py-2 px-4 text-center">#</th>
                            <th class="py-2 px-4 text-center">Photo</th>
                            <th class="py-2 px-4 text-center">Nom</th>
                            <th class="py-2 px-4 text-center">Prénom</th>
                            <th class="py-2 px-4 text-center">Poste</th>
                            <th class="py-2 px-4 text-center">Équipe</th>
                            <th class="py-2 px-4 text-center">MJ</th>
                            <th class="py-2 px-4 text-center">Buts</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $poolJoueurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b border-gray-200 dark:border-gray-700 text-center align-middle hover:bg-blue-50 dark:hover:bg-blue-900 transition cursor-pointer" onclick="window.location='<?php echo e(route('public.joueurs.show', $joueur->id)); ?>'">
                            <td class="py-2 px-4 font-semibold text-gray-800 dark:text-gray-100"><?php echo e($index+1); ?></td>
                            <td class="py-2 px-4">
                                <?php if($joueur->photo): ?>
                                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white border border-gray-200 dark:border-gray-700 overflow-hidden mx-auto">
                                        <img src="<?php echo e(asset('storage/' . $joueur->photo)); ?>" alt="Photo <?php echo e($joueur->nom); ?>" class="h-10 w-10 object-cover" onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'flex h-10 w-10 rounded-full bg-green-100 text-green-700 font-bold items-center justify-center\'><?php echo e(strtoupper(substr($joueur->nom,0,1))); ?></span>'">
                                    </span>
                                <?php else: ?>
                                    <span class="flex h-10 w-10 rounded-full bg-green-100 text-green-700 font-bold items-center justify-center"><?php echo e(strtoupper(substr($joueur->nom,0,1))); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="py-2 px-4"><?php echo e($joueur->nom); ?></td>
                            <td class="py-2 px-4"><?php echo e($joueur->prenom); ?></td>
                            <td class="py-2 px-4"><?php echo e($joueur->poste); ?></td>
                            <td class="py-2 px-4"><?php echo e($joueur->equipe->nom ?? '-'); ?></td>
                            <td class="py-2 px-4"><?php echo e($joueur->matchs_joues); ?></td>
                            <td class="py-2 px-4 font-bold"><?php echo e($joueur->buts_count); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <div class="mt-4 text-center">
                    <a href="<?php echo e(route('public.joueurs.search', ['top' => 'buteurs', 'pool_id' => $pool->id])); ?>" class="inline-block bg-blue-700 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-900 transition">Voir le classement complet</a>
                </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php elseif(isset($joueurs)): ?>
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 overflow-x-auto">
            <?php if($joueurs->isEmpty()): ?>
                <p class="text-center text-gray-500">Aucun joueur trouvé.</p>
            <?php else: ?>
            <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow table-fixed">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="py-2 px-4 text-center">#</th>
                        <th class="py-2 px-4 text-center">Photo</th>
                        <th class="py-2 px-4 text-center">Nom</th>
                        <th class="py-2 px-4 text-center">Prénom</th>
                        <th class="py-2 px-4 text-center">Poste</th>
                        <th class="py-2 px-4 text-center">Équipe</th>
                        <th class="py-2 px-4 text-center">MJ</th>
                        <?php if(isset($top) && $top === 'buteurs'): ?>
                        <th class="py-2 px-4 text-center">Buts</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $joueurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b border-gray-200 dark:border-gray-700 text-center align-middle hover:bg-blue-50 dark:hover:bg-blue-900 transition cursor-pointer" onclick="window.location='<?php echo e(route('public.joueurs.show', $joueur->id)); ?>'">
                        <td class="py-2 px-4 font-semibold text-gray-800 dark:text-gray-100"><?php echo e($index+1); ?></td>
                        <td class="py-2 px-4">
                            <?php if($joueur->photo): ?>
                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white border border-gray-200 dark:border-gray-700 overflow-hidden mx-auto">
                                    <img src="<?php echo e(asset('storage/' . $joueur->photo)); ?>" alt="Photo <?php echo e($joueur->nom); ?>" class="h-10 w-10 object-cover" onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'flex h-10 w-10 rounded-full bg-green-100 text-green-700 font-bold items-center justify-center\'><?php echo e(strtoupper(substr($joueur->nom,0,1))); ?></span>'">
                                </span>
                            <?php else: ?>
                                <span class="flex h-10 w-10 rounded-full bg-green-100 text-green-700 font-bold items-center justify-center"><?php echo e(strtoupper(substr($joueur->nom,0,1))); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-4 text-gray-800 dark:text-gray-100">
                            <a href="<?php echo e(route('public.joueurs.show', $joueur->id)); ?>" class="block w-full h-full focus:outline-none focus:ring-2 focus:ring-blue-500 rounded transition-colors duration-200">
                                <?php echo e($joueur->nom); ?>

                            </a>
                        </td>
                        <td class="py-2 px-4 text-gray-800 dark:text-gray-100"><?php echo e($joueur->prenom); ?></td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200"><?php echo e($joueur->poste); ?></td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200"><?php echo e($joueur->equipe->nom ?? '-'); ?></td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200"><?php echo e($joueur->matchs_joues ?? 0); ?></td>
                        <?php if(isset($top) && $top === 'buteurs'): ?>
                        <td class="py-2 px-4 text-blue-700 dark:text-blue-300 font-bold text-lg"><?php echo e($joueur->buts_count ?? 0); ?></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/public/joueurs_search.blade.php ENDPATH**/ ?>