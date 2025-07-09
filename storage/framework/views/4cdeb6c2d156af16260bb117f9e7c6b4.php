

<?php $__env->startSection('title', 'Gestion des Joueurs'); ?>

<?php $__env->startSection('header'); ?>
    Gestion des Joueurs (Saison : <?php echo e($saison?->nom ?? 'Aucune'); ?>)
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 shadow"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<div class="mb-6 flex justify-between items-center">
    <a href="<?php echo e(route('admin.joueurs.create')); ?>" class="bg-green-700 text-white px-4 py-2 rounded-lg shadow hover:bg-green-800 border border-green-700 transition">Ajouter un joueur</a>
    <div class="flex gap-2">
        <a href="<?php echo e(route('admin.joueurs.export', request()->all())); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">Exporter Excel</a>
        <a href="<?php echo e(route('admin.joueurs.exportPdf', request()->all())); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">Exporter PDF</a>
    </div>
</div>
<button onclick="window.history.back()" class="mb-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 border border-yellow-500 transition">← Retour</button>
<form method="GET" action="<?php echo e(route('admin.joueurs.index')); ?>" class="mb-4 flex flex-wrap gap-4 items-end bg-bl-card p-4 rounded-lg shadow border border-bl-border">
    <div>
        <label class="block font-semibold text-gray-700 dark:text-gray-200">Équipe</label>
        <select name="equipe_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
            <option value="">Toutes</option>
            <option value="libre" <?php echo e(request('equipe_id') === 'libre' ? 'selected' : ''); ?>>Libres (sans équipe)</option>
            <?php $__currentLoopData = $equipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($equipe->id); ?>" <?php echo e(request('equipe_id') == $equipe->id ? 'selected' : ''); ?>><?php echo e($equipe->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="block font-semibold text-gray-700 dark:text-gray-200">Saison</label>
        <select name="saison_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
            <option value="all" <?php echo e(request('saison_id', 'all') === 'all' ? 'selected' : ''); ?>>Toutes</option>
            <?php if(isset($saisons)): ?>
                <?php $__currentLoopData = $saisons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>" <?php echo e(request('saison_id') == $s->id ? 'selected' : ''); ?>><?php echo e($s->annee ?? $s->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </select>
    </div>
    <div>
        <label class="block font-semibold text-gray-700 dark:text-gray-200">Recherche</label>
        <input type="text" name="nom" value="<?php echo e(request('nom')); ?>" placeholder="Nom, prénom..." class="form-input w-64 rounded border-gray-300 dark:bg-gray-700 dark:text-white" />
    </div>
    <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-900 transition">Rechercher</button>
</form>
<div class="mb-4 flex flex-wrap gap-4 items-end">
</div>
<table class="min-w-full bg-bl-card rounded-lg shadow mt-4 table-fixed joueurs-table border border-bl-border">
    <thead class="bg-[#23272a]">
        <tr>
            <th class="py-2 px-4 w-20 text-center text-white">Photo</th>
            <th class="py-2 px-4 w-32 text-center text-white">Nom</th>
            <th class="py-2 px-4 w-32 text-center text-white">Prénom</th>
            <th class="py-2 px-4 w-32 text-center text-white">Date naissance</th>
            <th class="py-2 px-4 w-24 text-center text-white">Poste</th>
            <th class="py-2 px-4 w-40 text-center text-white">Équipe</th>
            <th class="py-2 px-4 w-28 text-center text-white">Licence</th>
            <th class="py-2 px-4 w-20 text-center text-white">Dossard</th>
            <th class="py-2 px-4 w-28 text-center text-white">Nationalité</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $joueurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $rowClass = 'border-b border-bl-border text-center align-middle hover:bg-bl-dark transition cursor-pointer';
        ?>
        <tr class="<?php echo e($rowClass); ?>" onclick="window.location='<?php echo e(route('admin.joueurs.show', $joueur)); ?>'">
            <td class="py-2 px-4">
                <?php if($joueur->photo): ?>
                    <img src="<?php echo e(asset('storage/' . $joueur->photo)); ?>" alt="Photo" class="h-10 w-10 rounded-full object-cover border border-bl-border bg-bl-card mx-auto" onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'h-10 w-10 rounded-full bg-[#23272a] flex items-center justify-center mx-auto\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#b0b0b0\' viewBox=\'0 0 24 24\' class=\'h-8 w-8\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z\'/></svg></div>'">
                <?php else: ?>
                    <div class="h-10 w-10 rounded-full bg-[#23272a] flex items-center justify-center mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-8 w-8">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                        </svg>
                    </div>
                <?php endif; ?>
            </td>
            <td class="py-2 px-4 font-semibold text-white"><?php echo e($joueur->nom); ?></td>
            <td class="py-2 px-4 text-white"><?php echo e($joueur->prenom); ?></td>
            <td class="py-2 px-4 text-white"><?php echo e($joueur->date_naissance); ?></td>
            <td class="py-2 px-4 text-white"><?php echo e($joueur->poste); ?></td>
            <td class="py-2 px-4 text-white"><?php echo e($joueur->equipe ? $joueur->equipe->nom : 'Libre'); ?></td>
            <td class="py-2 px-4 font-mono text-white"><?php echo e($joueur->numero_licence ?? '-'); ?></td>
            <td class="py-2 px-4 font-mono text-white"><?php echo e($joueur->numero_dossard ?? '-'); ?></td>
            <td class="py-2 px-4 text-white"><?php echo e($joueur->nationalite ?? '-'); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<div class="mt-6 flex justify-center">
    <?php echo e($joueurs->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/joueurs/index.blade.php ENDPATH**/ ?>