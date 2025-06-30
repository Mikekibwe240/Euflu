

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Ajouter un article</h2>
    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php
        $saisonCourante = $saisons->firstWhere('etat', 'ouverte');
        $saisonSelected = old('saison_id', $saisonCourante?->id);
    ?>
    <form action="<?php echo e(route('admin.articles.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white dark:bg-gray-800 p-6 rounded shadow text-gray-900 dark:text-gray-100">
        <?php echo csrf_field(); ?>
        <div>
            <label for="titre" class="block font-semibold">Titre</label>
            <select name="titre" id="titre" class="form-select w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" required>
                <option value="">Sélectionner un titre</option>
                <?php $__currentLoopData = ['Actualités', 'Communiqué', 'Interview', 'Annonce', 'Joueur du mois']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $titre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($titre); ?>" <?php echo e(old('titre') == $titre ? 'selected' : ''); ?>><?php echo e($titre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
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
            <label for="contenu" class="block font-semibold">Contenu</label>
            <textarea name="contenu" id="contenu" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" rows="6" required><?php echo e(old('contenu')); ?></textarea>
            <?php $__errorArgs = ['contenu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="saison_id" class="block font-semibold">Saison</label>
            <select name="saison_id" id="saison_id" class="form-select w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" required>
                <option value="">Sélectionner une saison</option>
                <?php $__currentLoopData = $saisons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saison): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($saison->id); ?>" <?php echo e($saisonSelected == $saison->id ? 'selected' : ''); ?>><?php echo e($saison->annee); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['saison_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="published_at" class="block font-semibold">Date de publication</label>
            <input type="datetime-local" name="published_at" id="published_at" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" value="<?php echo e(old('published_at', now()->setTimezone('Africa/Kinshasa')->format('Y-m-d\TH:i'))); ?>">
            <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="video" class="block font-semibold">Vidéo (optionnel, mp4)</label>
            <input type="file" name="video" id="video" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" accept="video/mp4">
            <?php $__errorArgs = ['video'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="image1" class="block font-semibold">Image 1 (optionnel)</label>
            <input type="file" name="images[]" id="image1" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" accept="image/*">
            <?php $__errorArgs = ['images.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="image2" class="block font-semibold">Image 2 (optionnel)</label>
            <input type="file" name="images[]" id="image2" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" accept="image/*">
            <?php $__errorArgs = ['images.1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="image3" class="block font-semibold">Image 3 (optionnel)</label>
            <input type="file" name="images[]" id="image3" class="form-input w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100" accept="image/*">
            <?php $__errorArgs = ['images.2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="flex gap-4 items-center">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Ajouter</button>
            <button type="button" onclick="apercuArticle()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Aperçu</button>
            <a href="<?php echo e(route('admin.articles.index')); ?>" class="ml-4 text-gray-600 hover:underline">Annuler</a>
        </div>
    </form>
    <script>
    function apercuArticle() {
        const titre = document.getElementById('titre').value;
        const contenu = document.getElementById('contenu').value;
        const win = window.open('', '_blank');
        win.document.write('<h2>' + titre + '</h2><div>' + contenu.replace(/\n/g, '<br>') + '</div>');
    }
    </script>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/articles/create.blade.php ENDPATH**/ ?>