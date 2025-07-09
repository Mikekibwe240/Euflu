<div class="max-w-4xl mx-auto bg-bl-card border border-bl-border rounded-xl shadow-lg p-8 mt-8">
    <h2 class="text-xl font-bold mb-4 text-bl-accent">Effectif du match : <?php echo e($match->equipe1->nom); ?> vs <?php echo e($match->equipe2->nom); ?><br><span class="text-base font-normal text-gray-400">Équipe : <?php echo e($equipe->nom); ?></span></h2>
    <!--[if BLOCK]><![endif]--><?php if(session()->has('success')): ?>
        <div class="mb-4 p-2 bg-green-900/80 text-green-200 border border-green-700 rounded"><?php echo e(session('success')); ?></div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <form wire:submit.prevent="save">
        <div class="mb-6">
            <label class="block font-semibold mb-2 text-white">Titulaires (11 joueurs)</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $joueurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="flex items-center space-x-2 text-white bg-bl-dark px-2 py-1 rounded">
                        <input type="checkbox" wire:model="titulaires" value="<?php echo e($joueur->id); ?>" <?php if(in_array($joueur->id, $remplacants)): ?> disabled <?php endif; ?>>
                        <span><?php echo e($joueur->nom); ?></span>
                    </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['titulaires'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-red-600 text-sm mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <div class="mb-6">
            <label class="block font-semibold mb-2 text-white">Remplaçants (max 5)</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $joueurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="flex items-center space-x-2 text-white bg-bl-dark px-2 py-1 rounded">
                        <input type="checkbox" wire:model="remplacants" value="<?php echo e($joueur->id); ?>" <?php if(in_array($joueur->id, $titulaires)): ?> disabled <?php endif; ?>>
                        <span><?php echo e($joueur->nom); ?></span>
                    </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['remplacants'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-red-600 text-sm mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <div class="mb-6">
            <label class="block font-semibold mb-2 text-white">Remplacements (pour chaque remplaçant, qui a-t-il remplacé ?)</label>
            <div class="space-y-2">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $remplacants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remplacantId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex flex-col md:flex-row md:items-center md:space-x-2 space-y-2 md:space-y-0 text-white">
                        <div class="flex items-center space-x-2">
                            <span class="font-medium"><?php echo e($joueurs->find($remplacantId)?->nom); ?></span>
                            <span>→</span>
                            <!--[if BLOCK]><![endif]--><?php if(count($titulaires) > 0): ?>
                                <select wire:model="remplacements.<?php echo e($remplacantId); ?>.joueur" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent rounded px-2 py-1">
                                    <option value="">-- Choisir le joueur remplacé --</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $titulaires; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $titulaireId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($titulaireId); ?>"><?php echo e($joueurs->find($titulaireId)?->nom); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                            <?php else: ?>
                                <span class="italic text-gray-400">Sélectionnez d'abord les titulaires</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <input type="number" min="1" max="120" wire:model="remplacements.<?php echo e($remplacantId); ?>.minute" class="form-input w-24 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent rounded px-2 py-1" placeholder="Minute">
                    </div>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['remplacements.' . $remplacantId . '.joueur'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-red-600 text-sm mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['remplacements.' . $remplacantId . '.minute'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-red-600 text-sm mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
        <!--[if BLOCK]><![endif]--><?php if($errors->any()): ?>
            <div class="mb-4 p-2 bg-red-900/80 text-red-200 border border-red-700 rounded">
                <ul class="list-disc pl-5">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow border border-green-600 transition">Enregistrer l'effectif</button>
    </form>
</div>
<?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/livewire/effectif-match-form.blade.php ENDPATH**/ ?>