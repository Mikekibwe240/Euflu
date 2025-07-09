

<?php $__env->startSection('title', 'Gestion des Équipes'); ?>

<?php $__env->startSection('header'); ?>
    Gestion des Équipes (Saison : <?php echo e($saison?->nom ?? 'Aucune'); ?>)
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 shadow"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<div class="mb-6 flex justify-between items-center">
    <a href="<?php echo e(route('admin.equipes.create')); ?>" class="bg-green-700 text-white px-4 py-2 rounded-lg shadow hover:bg-green-800 border border-green-700 transition">Ajouter une équipe</a>
    <div class="flex gap-2">
        <a href="<?php echo e(route('admin.equipes.export', request()->all())); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">Exporter Excel</a>
        <a href="<?php echo e(route('admin.equipes.exportPdf')); ?>" class="inline-block px-4 py-2 bg-bl-accent text-white rounded hover:bg-bl-dark transition">Exporter PDF</a>
    </div>
</div>
<button onclick="window.history.back()" class="mb-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 border border-yellow-500 transition">← Retour</button>
<form method="GET" action="<?php echo e(route('admin.equipes.index')); ?>" class="mb-4 flex flex-wrap gap-4 items-end bg-bl-card p-4 rounded-lg shadow border border-bl-border">
    <div>
        <label class="block font-semibold text-gray-700 dark:text-gray-200">Nom</label>
        <input type="text" name="nom" value="<?php echo e(request('nom')); ?>" class="form-input w-48 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
    </div>
    <div>
        <label class="block font-semibold text-gray-700 dark:text-gray-200">
            Pool
            <span title="Une équipe libre n'est rattachée à aucune poule et peut participer à des rencontres amicales ou externes."
                  class="ml-1 text-blue-500 cursor-help" style="font-size:1.1em;">&#9432;</span>
        </label>
        <select name="pool_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
            <option value="">Tous</option>
            <option value="libre" <?php echo e(request('pool_id') === 'libre' ? 'selected' : ''); ?>>Libre</option>
            <?php $__currentLoopData = $pools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($pool->id); ?>" <?php echo e(request('pool_id') == $pool->id ? 'selected' : ''); ?>><?php echo e($pool->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="block font-semibold text-gray-700 dark:text-gray-200">Saison</label>
        <select name="saison_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
            <option value="">Actuelle</option>
            <?php $__currentLoopData = $saisons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s->id); ?>" <?php echo e(request('saison_id') == $s->id ? 'selected' : ''); ?>><?php echo e($s->annee ?? $s->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-900 transition">Rechercher</button>
</form>
<table class="min-w-full bg-bl-card rounded-lg shadow mt-4 table-fixed equipes-table border border-bl-border">
    <thead class="bg-[#23272a]">
        <tr>
            <th class="py-2 px-4 w-20 text-center text-white">Logo</th>
            <th class="py-2 px-4 w-40 text-center text-white">Nom</th>
            <th class="py-2 px-4 w-32 text-center text-white">Pool</th>
            <th class="py-2 px-4 w-40 text-center text-white">Coach</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $equipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $rowClass = 'border-b border-bl-border text-center align-middle hover:bg-bl-dark transition cursor-pointer';
                if (is_null($equipe->pool_id)) $rowClass .= ' bg-green-900';
            ?>
            <tr class="<?php echo e($rowClass); ?>" onclick="window.location='<?php echo e(route('admin.equipes.show', $equipe)); ?>'">
                <td class="py-2 px-4 text-center">
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full border border-bl-border overflow-hidden bg-bl-card align-middle">
                        <?php if($equipe->logo): ?>
                            <img src="<?php echo e(asset('storage/' . $equipe->logo)); ?>" alt="Logo" class="h-10 w-10 object-cover block" style="object-fit:cover;object-position:center;" onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'inline-flex items-center justify-center h-10 w-10 rounded-full bg-[#23272a]\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#e2001a\' viewBox=\'0 0 24 24\' style=\'height:20px;width:20px;\'><circle cx=\'12\' cy=\'12\' r=\'10\' fill=\'#23272a\'/><path d=\'M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z\' fill=\'#e2001a\'/><circle cx=\'12\' cy=\'12\' r=\'3\' fill=\'#fff\'/></svg></span>'">
                        <?php else: ?>
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-[#23272a]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#e2001a" viewBox="0 0 24 24" style="height:20px;width:20px;">
                                    <circle cx="12" cy="12" r="10" fill="#23272a"/>
                                    <path d="M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z" fill="#e2001a"/>
                                    <circle cx="12" cy="12" r="3" fill="#fff"/>
                                </svg>
                            </span>
                        <?php endif; ?>
                    </span>
                </td>
                <td class="py-2 px-4 font-semibold text-white">
                    <?php echo e($equipe->nom); ?>

                    <?php if(is_null($equipe->pool_id)): ?>
                        <span class="ml-2 px-2 py-1 rounded text-xs font-bold bg-green-700 text-white align-middle">LIBRE</span>
                    <?php endif; ?>
                </td>
                <td class="py-2 px-4 text-white">
                    <?php echo e($equipe->pool->nom ?? (is_null($equipe->pool_id) ? 'Libre' : '-')); ?>

                </td>
                <td class="py-2 px-4 text-white"><?php echo e($equipe->coach); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<div class="mt-6 flex justify-center">
    <?php echo e($equipes->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Suppression du script de recherche rapide
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/equipes/index.blade.php ENDPATH**/ ?>