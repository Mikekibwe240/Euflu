

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Ajouter un règlement</h2>
    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-white p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?php echo e(route('admin.reglements.store')); ?>" method="POST" class="space-y-4 bg-bl-card border border-bl-border p-6 rounded-xl shadow-lg text-bl-accent" autocomplete="off">
        <?php echo csrf_field(); ?>
        <div>
            <label for="titre" class="block font-semibold mb-1 text-white">Titre</label>
            <input type="text" name="titre" id="titre" class="form-input w-full bg-bl-dark border-bl-border rounded-lg text-white" value="<?php echo e(old('titre')); ?>" required>
            <?php $__errorArgs = ['titre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="contenu" class="block font-semibold mb-1 text-white">Contenu</label>
            <textarea name="contenu" id="contenu" class="form-input w-full bg-bl-dark border-bl-border rounded-lg text-white" rows="6" required><?php echo e(old('contenu')); ?></textarea>
            <?php $__errorArgs = ['contenu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="flex gap-4 items-center mt-6">
            <button type="submit" class="bg-bl-accent hover:bg-bl-accent/90 text-white font-semibold px-6 py-2 rounded-lg shadow transition">Enregistrer</button>
            <a href="<?php echo e(route('admin.reglements.index')); ?>" class="ml-4 text-bl-accent hover:underline">Annuler</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/reglements/create.blade.php ENDPATH**/ ?>