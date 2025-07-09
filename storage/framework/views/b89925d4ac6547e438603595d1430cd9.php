

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-extrabold mb-6 text-white tracking-wide">Liste des articles</h2>
    <?php if(session('success')): ?>
        <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => ['type' => 'success','message' => session('success'),'class' => 'mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success','message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('success')),'class' => 'mb-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
    <?php endif; ?>
    <div class="flex flex-wrap gap-4 mb-4">
        <a href="<?php echo e(route('admin.articles.create')); ?>" class="bg-green-700 text-white px-4 py-2 rounded-lg shadow hover:bg-green-800 border border-green-700 transition">Créer / Publier un article</a>
        <a href="<?php echo e(route('admin.articles.export', request()->all())); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">Exporter Excel</a>
        <button onclick="window.history.back()" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">← Retour</button>
    </div>
    <form method="GET" action="<?php echo e(route('admin.articles.index')); ?>" class="mb-4 flex flex-wrap gap-4 items-end bg-bl-card p-4 rounded-lg shadow border border-bl-border">
        <div>
            <label class="block font-semibold text-gray-200">Saison</label>
            <select name="saison_id" class="form-select w-40 rounded border-bl-border bg-gray-800 text-white">
                <option value="">Toutes</option>
                <?php $__currentLoopData = $saisons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s->id); ?>" <?php echo e(request('saison_id') == $s->id ? 'selected' : ''); ?>>
                        <?php echo e($s->nom ?? $s->annee); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-200">Titre</label>
            <select name="titre" class="form-select w-40 rounded border-bl-border bg-gray-800 text-white">
                <option value="">Tous</option>
                <?php $__currentLoopData = ['Actualités', 'Communiqué', 'Interview', 'Annonce', 'Joueur du mois']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $titre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($titre); ?>" <?php echo e(request('titre') == $titre ? 'selected' : ''); ?>><?php echo e($titre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label class="block font-semibold text-gray-200">Auteur</label>
            <input type="text" name="auteur" class="form-input w-40 rounded border-bl-border bg-gray-800 text-white" placeholder="Auteur" value="<?php echo e(request('auteur')); ?>">
        </div>
        <div>
            <label class="block font-semibold text-gray-200">Recherche</label>
            <input type="text" name="q" class="form-input w-60 rounded border-bl-border bg-gray-800 text-white" placeholder="Contenu..." value="<?php echo e(request('q')); ?>">
        </div>
        <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-900 transition">Filtrer</button>
        <a href="<?php echo e(route('admin.articles.index')); ?>" class="bg-gray-300 text-gray-800 px-4 py-2 rounded ml-2">Réinitialiser</a>
    </form>
    <div class="mb-4 flex flex-wrap gap-4 items-end">
        <input type="text" id="search-articles" placeholder="Recherche rapide..." class="form-input w-64 rounded border-bl-border bg-gray-800 text-white" />
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-bl-card border border-bl-border rounded-xl p-4 flex flex-col items-center shadow">
            <div class="text-2xl font-bold text-white"><?php echo e($articles->total()); ?></div>
            <div class="text-sm text-white font-semibold">Articles</div>
        </div>
        <div class="bg-bl-card border border-bl-border rounded-xl p-4 flex flex-col items-center shadow">
            <div class="text-2xl font-bold text-green-400"><?php echo e($articles->where('type', 'Actualités')->count()); ?></div>
            <div class="text-sm text-green-400 font-semibold">Actualités</div>
        </div>
        <div class="bg-bl-card border border-bl-border rounded-xl p-4 flex flex-col items-center shadow">
            <div class="text-2xl font-bold text-yellow-400"><?php echo e($articles->where('type', 'Communiqué')->count()); ?></div>
            <div class="text-sm text-yellow-400 font-semibold">Communiqués</div>
        </div>
        <div class="bg-bl-card border border-bl-border rounded-xl p-4 flex flex-col items-center shadow">
            <div class="text-2xl font-bold text-purple-400"><?php echo e($articles->where('type', 'Interview')->count()); ?></div>
            <div class="text-sm text-purple-400 font-semibold">Interviews</div>
        </div>
    </div>
    <div class="overflow-x-auto rounded shadow">
    <table class="min-w-full bg-bl-card text-white rounded table-fixed articles-table border border-bl-border">
        <thead class="bg-[#23272a]">
            <tr>
                <th class="px-4 py-2 w-32 text-center text-white">Médias</th>
                <th class="px-4 py-2 w-40 text-center text-white">Titre</th>
                <th class="px-4 py-2 w-32 text-center text-white">Saison</th>
                <th class="px-4 py-2 w-32 text-center text-white">Date</th>
                <th class="px-4 py-2 w-32 text-center text-white">Auteur</th>
                <th class="px-4 py-2 w-32 text-center text-white">Modifié par</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-b border-bl-border text-center align-middle hover:bg-bl-dark transition cursor-pointer" onclick="window.location='<?php echo e(route('admin.articles.show', [$article])); ?>'">
                    <td class="px-4 py-2">
                        <div class="flex gap-2 items-center justify-center">
                            <?php if($article->video): ?>
                                <a href="<?php echo e(asset('storage/' . $article->video)); ?>" target="_blank" title="Voir la vidéo">
                                    <span class="flex w-12 h-12 bg-gray-700 items-center justify-center rounded shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-bl-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M4 6.5A2.5 2.5 0 016.5 4h11A2.5 2.5 0 0120 6.5v11a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 014 17.5v-11z" /></svg>
                                    </span>
                                </a>
                            <?php endif; ?>
                            <?php $__currentLoopData = $article->images->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <img src="<?php echo e(asset('storage/' . $img->path)); ?>" alt="Image article" class="w-12 h-12 object-cover rounded shadow border border-bl-border bg-bl-card" onerror="this.style.display='none'" />
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </td>
                    <td class="px-4 py-2 font-semibold text-white"><?php echo e($article->titre); ?></td>
                    <td class="px-4 py-2">
                        <?php echo e($article->saison->annee ?? '-'); ?>

                        <?php if($article->saison): ?>
                            <?php if($article->saison->etat === 'ouverte'): ?>
                                <span class="inline-block bg-green-500 text-white text-xs px-2 py-1 rounded ml-2">En cours</span>
                            <?php else: ?>
                                <span class="inline-block bg-red-500 text-white text-xs px-2 py-1 rounded ml-2">Clôturée</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-2"><?php echo e($article->created_at->format('d/m/Y')); ?></td>
                    <td class="px-4 py-2"><?php echo e($article->user->name ?? '-'); ?></td>
                    <td class="px-4 py-2"><?php echo e($article->updatedBy->name ?? '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="py-4 text-center text-gray-500">Aucun article trouvé.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
    <div class="mt-6 flex justify-center">
        <?php echo e($articles->links()); ?>

    </div>
</div>
<script>
function confirmDelete(form, titre) {
    if(confirm('Confirmer la suppression de l\'article : ' + titre + ' ?')) {
        return true;
    }
    return false;
}

document.getElementById('search-articles').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.articles-table tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/articles/index.blade.php ENDPATH**/ ?>