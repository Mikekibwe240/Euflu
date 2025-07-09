

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Ajouter un utilisateur</h2>
    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-white p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?php echo e(route('admin.users.store')); ?>" method="POST" class="space-y-4 bg-bl-card border border-bl-border p-6 rounded-xl shadow-lg text-bl-accent" autocomplete="off">
        <?php echo csrf_field(); ?>
        <div>
            <label for="name" class="block font-semibold mb-1 text-white">Nom</label>
            <input type="text" name="name" id="name" class="form-input w-full bg-bl-dark border-bl-border rounded-lg text-white" value="<?php echo e(old('name')); ?>" required>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="email" class="block font-semibold mb-1 text-white">Email</label>
            <input type="email" name="email" id="email" class="form-input w-full bg-bl-dark border-bl-border rounded-lg text-white" value="<?php echo e(old('email')); ?>" required>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="password" class="block font-semibold mb-1 text-white">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-input w-full bg-bl-dark border-bl-border rounded-lg text-white" required>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="password_confirmation" class="block font-semibold mb-1 text-white">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input w-full bg-bl-dark border-bl-border rounded-lg text-white" required>
        </div>
        <div>
            <label for="role" class="block font-semibold mb-1 text-white">Rôle</label>
            <select name="role" id="role" class="form-select w-full bg-bl-dark border-bl-border rounded-lg text-white" required>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($role); ?>" <?php echo e(old('role') == $role ? 'selected' : ''); ?>><?php echo e(ucfirst(str_replace('_', ' ', $role))); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['role'];
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
            <a href="<?php echo e(route('admin.users.index')); ?>" class="ml-4 text-bl-accent hover:underline">Annuler</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/users/create.blade.php ENDPATH**/ ?>