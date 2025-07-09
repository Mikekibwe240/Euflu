

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Modifier l'article</h2>
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
        $saisonActive = $saisons->firstWhere('active', 1);
        $saisonSelected = old('saison_id');
        if(!$saisonSelected) {
            $saisonSelected = $article->saison_id ?? $saisonActive?->id;
        }
    ?>
    <form action="<?php echo e(route('admin.articles.update', $article)); ?>" method="POST" enctype="multipart/form-data" class="space-y-4 bg-bl-card border border-bl-border p-6 rounded-xl shadow-lg" onsubmit="this.querySelector('[type=submit]').disabled=true; return true;" autocomplete="off">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <?php if($article->video || ($article->images && $article->images->count())): ?>
        <div class="mb-6">
            <label class="block font-semibold mb-2">Médias actuels</label>
            <div data-carousel class="relative w-full max-w-xl mx-auto">
                <?php if($article->video): ?>
                    <div data-carousel-item class="w-full">
                        <video src="<?php echo e(asset('storage/' . $article->video)); ?>" class="w-full h-64 object-cover rounded shadow border border-bl-border" autoplay muted loop playsinline></video>
                    </div>
                <?php endif; ?>
                <?php $__currentLoopData = $article->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div data-carousel-item class="w-full">
                        <img src="<?php echo e(asset('storage/' . $img->path)); ?>" class="w-full h-64 object-cover rounded shadow border border-bl-border" />
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <button type="button" data-carousel-prev class="absolute left-2 top-1/2 -translate-y-1/2 bg-bl-card/80 hover:bg-bl-accent/20 dark:bg-bl-dark/80 rounded-full p-2 shadow z-10">&#8249;</button>
                <button type="button" data-carousel-next class="absolute right-2 top-1/2 -translate-y-1/2 bg-bl-card/80 hover:bg-bl-accent/20 dark:bg-bl-dark/80 rounded-full p-2 shadow z-10">&#8250;</button>
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    <?php if($article->video): ?>
                        <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-bl-accent bg-bl-card transition-all duration-300 opacity-100"></button>
                    <?php endif; ?>
                    <?php $__currentLoopData = $article->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-bl-accent bg-bl-card transition-all duration-300 opacity-50"></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div>
            <label for="titre" class="block font-semibold text-white mb-1">Titre</label>
            <select name="titre" id="titre" class="form-select w-full bg-bl-dark border-bl-border rounded-lg text-white" required>
                <option value="">Sélectionner un titre</option>
                <?php $__currentLoopData = ['Actualités', 'Communiqué', 'Interview', 'Annonce', 'Joueur du mois']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $titre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($titre); ?>" <?php echo e(old('titre', $article->titre) == $titre ? 'selected' : ''); ?>><?php echo e($titre); ?></option>
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
            <label for="contenu" class="block font-semibold text-white mb-1">Contenu</label>
            <textarea name="contenu" id="contenu" class="form-input w-full bg-bl-dark border-bl-border rounded-lg text-white" rows="6" required><?php echo e(old('contenu', $article->contenu)); ?></textarea>
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
            <label for="video" class="block font-semibold text-white mb-1">Vidéo (optionnel, mp4)</label>
            <input type="file" name="video" id="video" class="form-input w-full bg-bl-dark border-bl-border rounded-lg text-white" accept="video/mp4">
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
            <label for="images" class="block font-semibold text-white mb-1">Images (optionnel, plusieurs possibles)</label>
            <input type="file" name="images[]" id="images" class="form-input w-full bg-bl-dark border-bl-border rounded-lg text-white" accept="image/*" multiple onchange="previewImages(event)">
            <?php $__errorArgs = ['images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div id="images-preview" class="flex flex-wrap gap-2 mt-2"></div>
        </div>
        <div>
            <label for="published_at" class="block font-semibold text-white mb-1">Date de publication</label>
            <?php
                $publishedAt = old('published_at', $article->published_at);
                if (is_string($publishedAt)) {
                    try {
                        $publishedAt = \Illuminate\Support\Carbon::parse($publishedAt);
                    } catch (Exception $e) {
                        $publishedAt = null;
                    }
                }
            ?>
            <input type="datetime-local" name="published_at" id="published_at" class="form-input w-full bg-bl-dark border-bl-border rounded-lg text-white" value="<?php echo e($publishedAt ? $publishedAt->format('Y-m-d\TH:i') : ''); ?>">
            <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="flex gap-4 items-center mt-6">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow border border-green-600 transition">Enregistrer</button>
            <a href="<?php echo e(route('admin.articles.index')); ?>" class="ml-4 bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-2 rounded shadow border border-yellow-500 transition">Annuler</a>
        </div>
    </form>
    <?php if($article->video): ?>
    <form action="<?php echo e(route('admin.articles.removeMedia', ['article' => $article->id, 'type' => 'video'])); ?>" method="POST" class="inline-block mt-2">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="bg-red-600 text-white rounded-full px-2 py-1 text-xs font-bold shadow hover:bg-red-800" title="Retirer la vidéo">✕ Supprimer la vidéo</button>
    </form>
    <?php endif; ?>
    <?php $__currentLoopData = $article->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <form action="<?php echo e(route('admin.articles.removeMedia', ['article' => $article->id, 'type' => 'image', 'image_id' => $img->id])); ?>" method="POST" class="inline-block mt-2">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="bg-red-600 text-white rounded-full px-2 py-1 text-xs font-bold shadow hover:bg-red-800" title="Retirer l'image">✕ Supprimer l'image</button>
    </form>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <script>
    function apercuArticle() {
        const titre = document.getElementById('titre').value;
        const contenu = document.getElementById('contenu').value;
        const win = window.open('', '_blank');
        win.document.write('<h2>' + titre + '</h2><div>' + contenu.replace(/\n/g, '<br>') + '</div>');
    }
    function previewImages(event) {
        const files = Array.from(event.target.files);
        const preview = document.getElementById('images-preview');
        preview.innerHTML = '';
        files.forEach((file, idx) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = e => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative inline-block';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'h-20 rounded shadow border border-bl-border';
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.innerHTML = '&times;';
                    btn.className = 'absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow hover:bg-red-800';
                    btn.onclick = function() {
                        removeImage(idx, event.target);
                    };
                    wrapper.appendChild(img);
                    wrapper.appendChild(btn);
                    preview.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            }
        });
    }
    function removeImage(idx, input) {
        const dt = new DataTransfer();
        const files = Array.from(input.files);
        files.splice(idx, 1);
        files.forEach(f => dt.items.add(f));
        input.files = dt.files;
        previewImages({target: input});
    }
    </script>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/articles/edit.blade.php ENDPATH**/ ?>