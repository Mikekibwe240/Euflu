

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto bg-bl-card border border-bl-border rounded-xl shadow-lg p-8 mt-8">
    <h2 class="text-2xl font-extrabold mb-6 text-bl-accent tracking-wide">Modifier la rencontre</h2>
    <form id="form-rencontre" action="<?php echo e(route('admin.rencontres.update', $rencontre)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-4">
            <label class="inline-flex items-center text-white">
                <input type="checkbox" id="hors_calendrier" name="hors_calendrier" value="1" class="form-checkbox accent-bl-accent" <?php echo e(old('hors_calendrier', $rencontre->type_rencontre === 'amical' ? 'checked' : '')); ?>>
                <span class="ml-2 font-semibold">Rencontre hors calendrier (amical ou externe)</span>
            </label>
        </div>
        <div id="pool_journee_block">
            <div>
                <label for="pool_id" class="block text-white font-semibold mb-1">Pool</label>
                <select name="pool_id" id="pool_id" class="w-full p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition">
                    <option value="">Sélectionner un pool</option>
                    <?php $__currentLoopData = $pools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($pool->id); ?>" <?php echo e(old('pool_id', $rencontre->pool_id) == $pool->id ? 'selected' : ''); ?>><?php echo e($pool->nom); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label for="journee" class="block text-white font-semibold mb-1">Journée</label>
                <input type="number" name="journee" id="journee" class="w-full p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" value="<?php echo e(old('journee', $rencontre->journee)); ?>">
            </div>
        </div>
        <div class="flex gap-4">
            <div class="w-1/2">
                <label for="equipe1_id" class="block text-white font-semibold mb-1">Équipe 1</label>
                <select name="equipe1_id" id="equipe1_id" class="w-full p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required>
                    <option value="">Sélectionner</option>
                    <?php $__currentLoopData = $equipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($equipe->id); ?>" data-pool="<?php echo e($equipe->pool_id ?? 'libre'); ?>" <?php echo e(old('equipe1_id', $rencontre->equipe1_id) == $equipe->id ? 'selected' : ''); ?>><?php echo e($equipe->nom); ?> (<?php echo e($equipe->pool->nom ?? 'Libre'); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="w-1/2">
                <label for="equipe2_id" class="block text-white font-semibold mb-1">Équipe 2</label>
                <select name="equipe2_id" id="equipe2_id" class="w-full p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus-border-bl-accent transition" required>
                    <option value="">Sélectionner</option>
                    <?php $__currentLoopData = $equipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($equipe->id); ?>" data-pool="<?php echo e($equipe->pool_id ?? 'libre'); ?>" <?php echo e(old('equipe2_id', $rencontre->equipe2_id) == $equipe->id ? 'selected' : ''); ?>><?php echo e($equipe->nom); ?> (<?php echo e($equipe->pool->nom ?? 'Libre'); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="flex gap-4">
            <div class="w-1/2">
                <label for="date" class="block text-white font-semibold mb-1">Date</label>
                <input type="date" name="date" id="date" class="w-full p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" value="<?php echo e(old('date', $rencontre->date)); ?>" required>
            </div>
            <div class="w-1/2">
                <label for="heure" class="block text-white font-semibold mb-1">Heure</label>
                <input type="time" name="heure" id="heure" class="w-full p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" value="<?php echo e(old('heure', $rencontre->heure)); ?>" required>
            </div>
        </div>
        <div>
            <label for="stade" class="block text-white font-semibold mb-1">Stade</label>
            <?php
                $stades = ['COKM', 'Annexe 1', 'Annexe 2', 'Jolie site', 'SGK'];
                $currentStade = old('stade', $rencontre->stade);
            ?>
            <select name="stade_select" id="stade_select" class="w-full p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition">
                <option value="">Sélectionner un stade</option>
                <?php $__currentLoopData = $stades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($stade); ?>" <?php echo e($currentStade == $stade ? 'selected' : ''); ?>><?php echo e($stade); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($currentStade && !in_array($currentStade, $stades)): ?>
                    <option value="<?php echo e($currentStade); ?>" selected><?php echo e($currentStade); ?> (autre)</option>
                <?php endif; ?>
            </select>
            <input type="text" name="stade" id="stade" class="w-full mt-2 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" placeholder="Autre stade..." value="<?php echo e($currentStade && !in_array($currentStade, $stades) ? $currentStade : ''); ?>">
        </div>
        <div id="form-error" class="text-red-400 font-semibold text-sm"></div>
        <div class="flex items-center gap-4 mt-6">
            <button type="submit" class="bg-bl-accent hover:bg-bl-dark text-white font-bold px-6 py-2 rounded shadow border border-bl-accent transition">Enregistrer</button>
            <a href="<?php echo e(route('admin.rencontres.index')); ?>" class="text-gray-400 hover:text-bl-accent underline transition">Annuler</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function updateFormUX() {
    const horsCalendrier = document.getElementById('hors_calendrier').checked;
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
                if (!poolId) {
                    opt.style.display = 'none';
                } else {
                    opt.style.display = (opt.dataset.pool === poolId) ? '' : 'none';
                }
            }
        });
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
document.getElementById('stade_select').addEventListener('change', function() {
    const val = this.value;
    document.getElementById('stade').value = val;
});
document.getElementById('stade').addEventListener('input', function() {
    if (this.value && !Array.from(document.getElementById('stade_select').options).some(opt => opt.value === this.value)) {
        document.getElementById('stade_select').value = '';
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/rencontres/edit.blade.php ENDPATH**/ ?>