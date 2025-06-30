

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Ajouter une rencontre</h2>
    <?php if($errors->any()): ?>
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 dark:bg-red-900 dark:text-red-200 rounded">
            <ul class="list-disc pl-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <form id="form-rencontre" action="<?php echo e(route('admin.rencontres.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white dark:bg-gray-800 p-6 rounded shadow text-gray-900 dark:text-gray-100">
        <?php echo csrf_field(); ?>
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" id="hors_calendrier" name="hors_calendrier" value="1" class="form-checkbox" <?php echo e(old('hors_calendrier') ? 'checked' : ''); ?>>
                <span class="ml-2 font-semibold">Rencontre hors calendrier (amical ou externe)</span>
            </label>
        </div>
        <div id="pool_journee_block">
            <div class="mb-4">
                <label for="pool_id" class="block font-semibold">Pool <span class="text-red-500">*</span></label>
                <select name="pool_id" id="pool_id" class="form-select w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" required>
                    <option value="">Sélectionner</option>
                    <?php $__currentLoopData = $pools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($pool->id); ?>" <?php echo e(old('pool_id') == $pool->id ? 'selected' : ''); ?>><?php echo e($pool->nom); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="journee" class="block font-semibold">Journée <span class="text-red-500">*</span></label>
                <input type="number" name="journee" id="journee" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" value="<?php echo e(old('journee')); ?>" required>
            </div>
        </div>
        <div id="type_rencontre_block" class="mb-4">
            <label class="block font-semibold">Type de rencontre <span class="text-red-500">*</span></label>
            <select name="type_rencontre" id="type_rencontre" class="form-select w-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700">
                <option value="amical" <?php echo e(old('type_rencontre') == 'amical' ? 'selected' : ''); ?>>Amical</option>
                <option value="externe" <?php echo e(old('type_rencontre') == 'externe' ? 'selected' : ''); ?>>Externe</option>
            </select>
        </div>
        <div class="flex gap-4">
            <div class="w-1/2">
                <label class="block font-semibold">Équipe 1 <span class="text-red-500">*</span></label>
                <select name="equipe1_id" id="equipe1_id" class="form-select w-full mb-2 bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" required>
                    <option value="">Sélectionner</option>
                    <?php $__currentLoopData = $equipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($equipe->id); ?>" data-pool="<?php echo e($equipe->pool_id ?? 'libre'); ?>"><?php echo e($equipe->nom); ?> (<?php echo e($equipe->pool->nom ?? 'Libre'); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="w-1/2">
                <label class="block font-semibold">Équipe 2 <span class="text-red-500">*</span></label>
                <select name="equipe2_id" id="equipe2_id" class="form-select w-full mb-2 bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" required>
                    <option value="">Sélectionner</option>
                    <?php $__currentLoopData = $equipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($equipe->id); ?>" data-pool="<?php echo e($equipe->pool_id ?? 'libre'); ?>"><?php echo e($equipe->nom); ?> (<?php echo e($equipe->pool->nom ?? 'Libre'); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="flex gap-4">
            <div class="w-1/2">
                <label for="date" class="block font-semibold">Date <span class="text-red-500">*</span></label>
                <input type="date" name="date" id="date" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" required>
            </div>
            <div class="w-1/2">
                <label for="heure" class="block font-semibold">Heure <span class="text-red-500">*</span></label>
                <input type="time" name="heure" id="heure" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" required>
            </div>
        </div>
        <div>
            <label for="stade" class="block font-semibold">Stade <span class="text-red-500">*</span></label>
            <input type="text" name="stade" id="stade" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" required>
        </div>
        <div id="form-error" class="text-red-600 font-semibold text-sm"></div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Enregistrer</button>
    </form>
</div>
<?php $__env->startSection('scripts'); ?>
<script>
function updateFormUX() {
    const horsCalendrier = document.getElementById('hors_calendrier').checked;
    // Afficher/cacher le champ Type de rencontre
    document.getElementById('type_rencontre_block').style.display = horsCalendrier ? 'none' : '';
    document.getElementById('type_rencontre').required = !horsCalendrier;
    document.getElementById('pool_journee_block').style.display = horsCalendrier ? 'none' : '';
    document.getElementById('pool_id').required = !horsCalendrier;
    document.getElementById('journee').required = !horsCalendrier;
    // Filtrage dynamique des équipes
    const poolId = document.getElementById('pool_id').value;
    [1,2].forEach(num => {
        const select = document.getElementById('equipe'+num+'_id');
        Array.from(select.options).forEach(opt => {
            if (!opt.value) return;
            if (horsCalendrier) {
                opt.style.display = '';
            } else {
                // Si pool sélectionné, ne montrer que les équipes du pool
                opt.style.display = (opt.dataset.pool === poolId) ? '' : 'none';
            }
        });
        // Reset si sélection non valide
        if (!horsCalendrier && select.value && select.options[select.selectedIndex].style.display === 'none') {
            select.value = '';
        }
    });
}
document.getElementById('hors_calendrier').addEventListener('change', updateFormUX);
document.getElementById('pool_id').addEventListener('change', updateFormUX);
window.addEventListener('DOMContentLoaded', function() {
    updateFormUX();
});
// Validation JS personnalisée simplifiée
const form = document.getElementById('form-rencontre');
form.addEventListener('submit', function(e) {
    const horsCalendrier = document.getElementById('hors_calendrier').checked;
    let error = '';
    if (!horsCalendrier) {
        if (!document.getElementById('pool_id').value) error = 'Veuillez sélectionner un pool.';
        else if (!document.getElementById('journee').value) error = 'Veuillez indiquer la journée.';
    }
    if (!document.getElementById('equipe1_id').value) error = 'Veuillez sélectionner l\'équipe 1.';
    if (!document.getElementById('equipe2_id').value) error = 'Veuillez sélectionner l\'équipe 2.';
    if (error) {
        document.getElementById('form-error').textContent = error;
        e.preventDefault();
        return false;
    } else {
        document.getElementById('form-error').textContent = '';
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/rencontres/create.blade.php ENDPATH**/ ?>