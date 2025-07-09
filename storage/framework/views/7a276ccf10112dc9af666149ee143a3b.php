

<?php $__env->startSection('title', 'Ajouter une Équipe'); ?>

<?php $__env->startSection('header'); ?>
    Ajouter une Équipe (Saison : <?php echo e($saison?->nom ?? 'Aucune'); ?>)
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-lg mx-auto bg-bl-card border border-bl-border rounded-xl shadow-lg p-8 mt-8">
    <h2 class="text-2xl font-extrabold mb-6 text-white tracking-wide">Ajouter une équipe</h2>
    <form action="<?php echo e(route('admin.equipes.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>
        <div>
            <label class="block text-white font-semibold mb-1">Nom de l'équipe</label>
            <input type="text" name="nom" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required value="<?php echo e(old('nom')); ?>">
            <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-400 text-sm mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Pool</label>
            <select name="pool_id" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition">
                <option value="">Aucun (équipe libre)</option>
                <?php $__currentLoopData = $pools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($pool->id); ?>" <?php if(old('pool_id') == $pool->id): ?> selected <?php endif; ?>><?php echo e($pool->nom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['pool_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-400 text-sm mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Coach</label>
            <input type="text" name="coach" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required value="<?php echo e(old('coach')); ?>">
            <?php $__errorArgs = ['coach'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-400 text-sm mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label class="block text-white font-semibold mb-1">Logo (optionnel)</label>
            <input type="file" name="logo" class="w-full mt-1 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition">
            <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-400 text-sm mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="flex items-center gap-4 mt-6">
            <button type="submit" class="bg-bl-accent hover:bg-bl-dark text-white font-bold px-6 py-2 rounded shadow border border-bl-accent transition">Ajouter l'équipe</button>
            <a href="<?php echo e(route('admin.equipes.index')); ?>" class="text-gray-400 hover:text-bl-accent underline transition">Annuler</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/equipes/create.blade.php ENDPATH**/ ?>