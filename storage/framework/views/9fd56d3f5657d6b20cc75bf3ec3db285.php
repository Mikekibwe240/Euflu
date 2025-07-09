
<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto bg-bl-card border border-bl-border rounded-xl shadow-lg p-8 mt-8">
    <h2 class="text-2xl font-extrabold mb-6 text-white tracking-wide">Saisir / Modifier le résultat</h2>
    <?php if($errors->any()): ?>
        <div class="bg-red-900/80 text-white border border-red-700 p-3 mb-6 rounded">
            <ul class="list-disc pl-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?php echo e(route('admin.rencontres.updateResultat', $rencontre)); ?>" method="POST" class="space-y-8">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="flex flex-wrap gap-4 items-center justify-between">
            <span class="font-semibold text-white min-w-[100px] truncate">
                <?php if($rencontre->equipe1_libre): ?>
                    <span class="italic text-gray-400"><?php echo e($rencontre->equipe1_libre); ?></span>
                <?php elseif($rencontre->equipe1): ?>
                    <?php echo e($rencontre->equipe1->nom); ?>

                <?php else: ?>
                    -
                <?php endif; ?>
            </span>
            <input type="number" name="score_equipe1" value="<?php echo e(old('score_equipe1', $rencontre->score_equipe1)); ?>" class="form-input w-20 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition text-center" min="0" required>
            <span class="mx-2 text-white text-xl font-bold">-</span>
            <input type="number" name="score_equipe2" value="<?php echo e(old('score_equipe2', $rencontre->score_equipe2)); ?>" class="form-input w-20 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition text-center" min="0" required>
            <span class="font-semibold text-white min-w-[100px] truncate">
                <?php if($rencontre->equipe2_libre): ?>
                    <span class="italic text-gray-400"><?php echo e($rencontre->equipe2_libre); ?></span>
                <?php elseif($rencontre->equipe2): ?>
                    <?php echo e($rencontre->equipe2->nom); ?>

                <?php else: ?>
                    -
                <?php endif; ?>
            </span>
        </div>
        <div class="text-xs text-gray-400 mb-2">
            <span>Le score doit être justifié par le même nombre de buteurs saisis pour chaque équipe.</span>
        </div>
        <hr class="border-bl-border">
        <h3 class="text-lg font-semibold mt-4 mb-2 text-white">Buteurs</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-semibold mb-2 text-white truncate"><?php echo e($rencontre->equipe1->nom ?? '-'); ?></h4>
                <div id="buteurs-equipe1-list">
                    <?php
                        $nb = old('score_equipe1', $rencontre->score_equipe1 ?? 0);
                        $buts = $rencontre->buts->where('equipe_id', $rencontre->equipe1->id ?? null)->values();
                    ?>
                    <?php
                        $oldButeurs = old('buteurs_equipe1', []);
                        $nb = max(count($oldButeurs), $buts->count(), old('score_equipe1', $rencontre->score_equipe1 ?? 0));
                    ?>
                    <?php for($i = 0; $i < $nb; $i++): ?>
                        <div class="flex flex-wrap gap-2 mb-2 buteur-row items-center">
                            <select name="buteurs_equipe1[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition w-40">
                                <option value="">Sélectionner un joueur</option>
                                <?php $__currentLoopData = $joueursEquipe1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($joueur->id); ?>" <?php if(old('buteurs_equipe1.'.$i, $buts[$i]->joueur_id ?? null) == $joueur->id): ?> selected <?php endif; ?>><?php echo e($joueur->nom); ?> <?php echo e($joueur->prenom); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <input type="number" name="minutes_buteurs_equipe1[]" class="form-input w-24 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" placeholder="Minute" value="<?php echo e(old('minutes_buteurs_equipe1.'.$i, $buts[$i]->minute ?? '')); ?>">
                        </div>
                    <?php endfor; ?>
                </div>
                <button type="button" id="add-buteur-equipe1" class="bg-green-700 text-white px-2 py-1 rounded mt-2">+ Ajouter buteur</button>
            </div>
            <div>
                <h4 class="font-semibold mb-2 text-white truncate"><?php echo e($rencontre->equipe2->nom ?? '-'); ?></h4>
                <div id="buteurs-equipe2-list">
                    <?php
                        $nb = old('score_equipe2', $rencontre->score_equipe2 ?? 0);
                        $buts = $rencontre->buts->where('equipe_id', $rencontre->equipe2->id ?? null)->values();
                    ?>
                    <?php
                        $oldButeurs = old('buteurs_equipe2', []);
                        $nb = max(count($oldButeurs), $buts->count(), old('score_equipe2', $rencontre->score_equipe2 ?? 0));
                    ?>
                    <?php for($i = 0; $i < $nb; $i++): ?>
                        <div class="flex flex-wrap gap-2 mb-2 buteur-row items-center">
                            <select name="buteurs_equipe2[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition w-40">
                                <option value="">Sélectionner un joueur</option>
                                <?php $__currentLoopData = $joueursEquipe2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($joueur->id); ?>" <?php if(old('buteurs_equipe2.'.$i, $buts[$i]->joueur_id ?? null) == $joueur->id): ?> selected <?php endif; ?>><?php echo e($joueur->nom); ?> <?php echo e($joueur->prenom); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <input type="number" name="minutes_buteurs_equipe2[]" class="form-input w-24 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" placeholder="Minute" value="<?php echo e(old('minutes_buteurs_equipe2.'.$i, $buts[$i]->minute ?? '')); ?>">
                        </div>
                    <?php endfor; ?>
                </div>
                <button type="button" id="add-buteur-equipe2" class="bg-green-700 text-white px-2 py-1 rounded mt-2">+ Ajouter buteur</button>
            </div>
        </div>
        <hr class="border-bl-border">
        <h3 class="text-lg font-semibold mt-4 mb-2 text-white">Cartons</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-semibold mb-2 text-white truncate">
                    <?php echo e($rencontre->equipe1->nom ?? '-'); ?>

                </h4>
                <div id="cartons-equipe1-list">
                    <?php
                        $cartons = $rencontre->cartons->where('equipe_id', $rencontre->equipe1->id ?? null)->values();
                        $oldCartons = old('cartons_equipe1', []);
                        $nb = max(count($oldCartons), $cartons->count(), 1);
                    ?>
                    <?php for($i = 0; $i < $nb; $i++): ?>
                        <div class="flex flex-wrap gap-2 mb-2 carton-row items-center">
                            <select name="cartons_equipe1[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition w-40">
                                <option value="">Sélectionner un joueur</option>
                                <?php $__currentLoopData = $joueursEquipe1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($joueur->id); ?>" <?php if(old('cartons_equipe1.'.$i, $cartons[$i]->joueur_id ?? null) == $joueur->id): ?> selected <?php endif; ?>><?php echo e($joueur->nom); ?> <?php echo e($joueur->prenom); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select name="type_cartons_equipe1[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition w-24">
                                <option value="jaune" <?php if(old('type_cartons_equipe1.'.$i, $cartons[$i]->type ?? null)=='jaune'): ?> selected <?php endif; ?>>Jaune</option>
                                <option value="rouge" <?php if(old('type_cartons_equipe1.'.$i, $cartons[$i]->type ?? null)=='rouge'): ?> selected <?php endif; ?>>Rouge</option>
                            </select>
                            <input type="number" name="minutes_cartons_equipe1[]" class="form-input w-20 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" placeholder="Minute" value="<?php echo e(old('minutes_cartons_equipe1.'.$i, $cartons[$i]->minute ?? null)); ?>">
                            <button type="button" class="remove-carton bg-red-500 text-white px-2 rounded">X</button>
                        </div>
                    <?php endfor; ?>
                </div>
                <button type="button" id="add-carton-equipe1" class="bg-yellow-600 text-white px-2 py-1 rounded mt-2">+ Ajouter carton</button>
            </div>
            <div>
                <h4 class="font-semibold mb-2 text-white truncate">
                    <?php echo e($rencontre->equipe2->nom ?? '-'); ?>

                </h4>
                <div id="cartons-equipe2-list">
                    <?php
                        $cartons = $rencontre->cartons->where('equipe_id', $rencontre->equipe2->id ?? null)->values();
                        $oldCartons = old('cartons_equipe2', []);
                        $nb = max(count($oldCartons), $cartons->count(), 1);
                    ?>
                    <?php for($i = 0; $i < $nb; $i++): ?>
                        <div class="flex flex-wrap gap-2 mb-2 carton-row items-center">
                            <select name="cartons_equipe2[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition w-40">
                                <option value="">Sélectionner un joueur</option>
                                <?php $__currentLoopData = $joueursEquipe2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($joueur->id); ?>" <?php if(old('cartons_equipe2.'.$i, $cartons[$i]->joueur_id ?? null) == $joueur->id): ?> selected <?php endif; ?>><?php echo e($joueur->nom); ?> <?php echo e($joueur->prenom); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select name="type_cartons_equipe2[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition w-24">
                                <option value="jaune" <?php if(old('type_cartons_equipe2.'.$i, $cartons[$i]->type ?? null)=='jaune'): ?> selected <?php endif; ?>>Jaune</option>
                                <option value="rouge" <?php if(old('type_cartons_equipe2.'.$i, $cartons[$i]->type ?? null)=='rouge'): ?> selected <?php endif; ?>>Rouge</option>
                            </select>
                            <input type="number" name="minutes_cartons_equipe2[]" class="form-input w-20 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" placeholder="Minute" value="<?php echo e(old('minutes_cartons_equipe2.'.$i, $cartons[$i]->minute ?? null)); ?>">
                            <button type="button" class="remove-carton bg-red-500 text-white px-2 rounded">X</button>
                        </div>
                    <?php endfor; ?>
                </div>
                <button type="button" id="add-carton-equipe2" class="bg-yellow-600 text-white px-2 py-1 rounded mt-2">+ Ajouter carton</button>
            </div>
        </div>
        
        <?php if($rencontre->equipe1_libre): ?>
            <div id="cartons-equipe1-libre-list">
                <?php
                    $cartonsLibre = $rencontre->cartons->where('equipe_id', null)->where('equipe_libre_nom', $rencontre->equipe1_libre)->values();
                    $oldCartonsLibre = old('cartons_equipe1_libre', []);
                    $nbLibre = max(count($oldCartonsLibre), $cartonsLibre->count(), 0);
                ?>
                <?php for($i = 0; $i < $nbLibre; $i++): ?>
                    <div class="flex gap-2 mb-2 carton-row">
                        <input type="text" name="cartons_equipe1_libre[]" class="form-input w-1/2" placeholder="Nom (libre)" value="<?php echo e(old('cartons_equipe1_libre.'.$i, $cartonsLibre[$i]->nom_libre ?? '')); ?>">
                        <select name="type_cartons_equipe1_libre[]" class="form-select w-1/4">
                            <option value="jaune" <?php if(old('type_cartons_equipe1_libre.'.$i, $cartonsLibre[$i]->type ?? null)=='jaune'): ?> selected <?php endif; ?>>Jaune</option>
                            <option value="rouge" <?php if(old('type_cartons_equipe1_libre.'.$i, $cartonsLibre[$i]->type ?? null)=='rouge'): ?> selected <?php endif; ?>>Rouge</option>
                        </select>
                        <input type="number" name="minutes_cartons_equipe1_libre[]" class="form-input w-1/4" placeholder="Minute" value="<?php echo e(old('minutes_cartons_equipe1_libre.'.$i, $cartonsLibre[$i]->minute ?? null)); ?>">
                        <button type="button" class="remove-carton bg-red-500 text-white px-2 rounded">X</button>
                    </div>
                <?php endfor; ?>
            </div>
            <button type="button" id="add-carton-equipe1-libre" class="bg-yellow-600 text-white px-2 py-1 rounded">+ Ajouter carton libre</button>
        <?php endif; ?>
        
        <?php if($rencontre->equipe2_libre): ?>
            <div id="cartons-equipe2-libre-list">
                <?php
                    $cartonsLibre = $rencontre->cartons->where('equipe_id', null)->where('equipe_libre_nom', $rencontre->equipe2_libre)->values();
                    $oldCartonsLibre = old('cartons_equipe2_libre', []);
                    $nbLibre = max(count($oldCartonsLibre), $cartonsLibre->count(), 0);
                ?>
                <?php for($i = 0; $i < $nbLibre; $i++): ?>
                    <div class="flex gap-2 mb-2 carton-row">
                        <input type="text" name="cartons_equipe2_libre[]" class="form-input w-1/2" placeholder="Nom (libre)" value="<?php echo e(old('cartons_equipe2_libre.'.$i, $cartonsLibre[$i]->nom_libre ?? '')); ?>">
                        <select name="type_cartons_equipe2_libre[]" class="form-select w-1/4">
                            <option value="jaune" <?php if(old('type_cartons_equipe2_libre.'.$i, $cartonsLibre[$i]->type ?? null)=='jaune'): ?> selected <?php endif; ?>>Jaune</option>
                            <option value="rouge" <?php if(old('type_cartons_equipe2_libre.'.$i, $cartonsLibre[$i]->type ?? null)=='rouge'): ?> selected <?php endif; ?>>Rouge</option>
                        </select>
                        <input type="number" name="minutes_cartons_equipe2_libre[]" class="form-input w-1/4" placeholder="Minute" value="<?php echo e(old('minutes_cartons_equipe2_libre.'.$i, $cartonsLibre[$i]->minute ?? null)); ?>">
                        <button type="button" class="remove-carton bg-red-500 text-white px-2 rounded">X</button>
                    </div>
                <?php endfor; ?>
            </div>
            <button type="button" id="add-carton-equipe2-libre" class="bg-yellow-600 text-white px-2 py-1 rounded">+ Ajouter carton libre</button>
        <?php endif; ?>
        <hr>
        <h3 class="text-lg font-semibold mt-4 mb-2 text-white">Homme du match (MVP)</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-1 text-white">
                    <?php echo e($rencontre->equipe1->nom ?? '-'); ?>

                </label>
                <select name="mvp_equipe1_id" class="form-select w-full bg-bl-dark text-white">
                    <option value="">Aucun</option>
                    <?php $__currentLoopData = $joueursEquipe1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($joueur->id); ?>" <?php if(old('mvp_equipe1_id', $rencontre->mvp_id) == $joueur->id): ?> selected <?php endif; ?>><?php echo e($joueur->nom); ?> <?php echo e($joueur->prenom); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-1 text-white">
                    <?php echo e($rencontre->equipe2->nom ?? '-'); ?>

                </label>
                <select name="mvp_equipe2_id" class="form-select w-full bg-bl-dark text-white">
                    <option value="">Aucun</option>
                    <?php $__currentLoopData = $joueursEquipe2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($joueur->id); ?>" <?php if(old('mvp_equipe2_id', $rencontre->mvp_id) == $joueur->id): ?> selected <?php endif; ?>><?php echo e($joueur->nom); ?> <?php echo e($joueur->prenom); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">Ne remplir qu’un seul champ MVP (un seul joueur ou nom sera retenu).</div>

        <div class="flex flex-wrap gap-4 mt-8 justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2 rounded shadow border border-green-600 transition">Enregistrer</button>
            <a href="<?php echo e(route('admin.rencontres.index')); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-2 rounded shadow border border-yellow-500 transition">Annuler</a>
        </div>
    </form>
</div>
<div class="max-w-4xl mx-auto mt-8">
    <?php if($rencontre->equipe1): ?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('effectif-match-form', ['matchId' => $rencontre->id, 'equipeId' => $rencontre->equipe1->id]);

$__html = app('livewire')->mount($__name, $__params, 'lw-3219043056-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php endif; ?>
    <?php if($rencontre->equipe2): ?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('effectif-match-form', ['matchId' => $rencontre->id, 'equipeId' => $rencontre->equipe2->id]);

$__html = app('livewire')->mount($__name, $__params, 'lw-3219043056-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php endif; ?>
</div>
<div class="flex justify-end mt-8">
    <a href="<?php echo e(route('admin.rencontres.show', $rencontre)); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-2 rounded shadow border border-yellow-500 transition inline-flex items-center">
        &#8592; Retour à la fiche de match
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
var joueursEquipe1 = <?php echo json_encode($joueursEquipe1 ?? [], 15, 512) ?>;
var joueursEquipe2 = <?php echo json_encode($joueursEquipe2 ?? [], 15, 512) ?>;
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter buteur équipe 1
    const btnAddButeur1 = document.getElementById('add-buteur-equipe1');
    if (btnAddButeur1) {
        btnAddButeur1.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'flex flex-wrap gap-2 mb-2 buteur-row items-center';
            let select = '<select name="buteurs_equipe1[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition w-40">';
            select += '<option value="">Sélectionner un joueur</option>';
            joueursEquipe1.forEach(j => select += `<option value="${j.id}">${j.nom} ${j.prenom}</option>`);
            select += '</select>';
            div.innerHTML = select + '<input type="number" name="minutes_buteurs_equipe1[]" class="form-input w-24 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" placeholder="Minute">' + '<button type="button" class="remove-buteur bg-red-500 text-white px-2 rounded">X</button>';
            document.getElementById('buteurs-equipe1-list').appendChild(div);
        });
    }
    // Supprimer buteur équipe 1 (délégation)
    document.getElementById('buteurs-equipe1-list').addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-buteur')) e.target.parentNode.remove();
    });
    // Ajouter buteur équipe 2
    const btnAddButeur2 = document.getElementById('add-buteur-equipe2');
    if (btnAddButeur2) {
        btnAddButeur2.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'flex flex-wrap gap-2 mb-2 buteur-row items-center';
            let select = '<select name="buteurs_equipe2[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition w-40">';
            select += '<option value="">Sélectionner un joueur</option>';
            joueursEquipe2.forEach(j => select += `<option value="${j.id}">${j.nom} ${j.prenom}</option>`);
            select += '</select>';
            div.innerHTML = select + '<input type="number" name="minutes_buteurs_equipe2[]" class="form-input w-24 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" placeholder="Minute">' + '<button type="button" class="remove-buteur bg-red-500 text-white px-2 rounded">X</button>';
            document.getElementById('buteurs-equipe2-list').appendChild(div);
        });
    }
    // Supprimer buteur équipe 2 (délégation)
    document.getElementById('buteurs-equipe2-list').addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-buteur')) e.target.parentNode.remove();
    });
    // Ajouter carton équipe 1
    const btnAddCarton1 = document.getElementById('add-carton-equipe1');
    if (btnAddCarton1) {
        btnAddCarton1.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'flex flex-wrap gap-2 mb-2 carton-row items-center';
            let select = '<select name="cartons_equipe1[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition w-40">';
            select += '<option value="">Sélectionner un joueur</option>';
            joueursEquipe1.forEach(j => select += `<option value="${j.id}">${j.nom} ${j.prenom}</option>`);
            select += '</select>';
            let type = '<select name="type_cartons_equipe1[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition w-24"><option value="jaune">Jaune</option><option value="rouge">Rouge</option></select>';
            div.innerHTML = select + type + '<input type="number" name="minutes_cartons_equipe1[]" class="form-input w-20 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" placeholder="Minute">' + '<button type="button" class="remove-carton bg-red-500 text-white px-2 rounded">X</button>';
            document.getElementById('cartons-equipe1-list').appendChild(div);
        });
    }
    // Supprimer carton équipe 1 (délégation)
    document.getElementById('cartons-equipe1-list').addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-carton')) e.target.parentNode.remove();
    });
    // Ajouter carton équipe 2
    const btnAddCarton2 = document.getElementById('add-carton-equipe2');
    if (btnAddCarton2) {
        btnAddCarton2.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'flex flex-wrap gap-2 mb-2 carton-row items-center';
            let select = '<select name="cartons_equipe2[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition w-40">';
            select += '<option value="">Sélectionner un joueur</option>';
            joueursEquipe2.forEach(j => select += `<option value="${j.id}">${j.nom} ${j.prenom}</option>`);
            select += '</select>';
            let type = '<select name="type_cartons_equipe2[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition w-24"><option value="jaune">Jaune</option><option value="rouge">Rouge</option></select>';
            div.innerHTML = select + type + '<input type="number" name="minutes_cartons_equipe2[]" class="form-input w-20 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" placeholder="Minute">' + '<button type="button" class="remove-carton bg-red-500 text-white px-2 rounded">X</button>';
            document.getElementById('cartons-equipe2-list').appendChild(div);
        });
    }
    // Supprimer carton équipe 2 (délégation)
    document.getElementById('cartons-equipe2-list').addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-carton')) e.target.parentNode.remove();
    });
    // Ajouter buteur équipe 1 (libre)
    const btnAddButeur1Libre = document.getElementById('add-buteur-equipe1-libre');
    if (btnAddButeur1Libre) {
        btnAddButeur1Libre.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2 buteur-row';
            div.innerHTML = '<input type="text" name="buteurs_equipe1_libre[]" class="form-input w-1/2" placeholder="Nom du buteur (libre)">' +
                '<input type="number" name="minutes_buteurs_equipe1_libre[]" class="form-input w-1/3" placeholder="Minute">' +
                '<button type="button" class="remove-buteur bg-red-500 text-white px-2 rounded">X</button>';
            document.getElementById('buteurs-equipe1-list').appendChild(div);
        });
    }
    // Ajouter buteur équipe 2 (libre)
    const btnAddButeur2Libre = document.getElementById('add-buteur-equipe2-libre');
    if (btnAddButeur2Libre) {
        btnAddButeur2Libre.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2 buteur-row';
            div.innerHTML = '<input type="text" name="buteurs_equipe2_libre[]" class="form-input w-1/2" placeholder="Nom du buteur (libre)">' +
                '<input type="number" name="minutes_buteurs_equipe2_libre[]" class="form-input w-1/3" placeholder="Minute">' +
                '<button type="button" class="remove-buteur bg-red-500 text-white px-2 rounded">X</button>';
            document.getElementById('buteurs-equipe2-list').appendChild(div);
        });
    }
    // Ajouter carton équipe 1 (libre)
    const btnAddCarton1Libre = document.getElementById('add-carton-equipe1-libre');
    if (btnAddCarton1Libre) {
        btnAddCarton1Libre.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2 carton-row';
            div.innerHTML = '<input type="text" name="cartons_equipe1_libre[]" class="form-input w-1/2" placeholder="Nom (libre)">' +
                '<select name="type_cartons_equipe1_libre[]" class="form-select w-1/4"><option value="jaune">Jaune</option><option value="rouge">Rouge</option></select>' +
                '<input type="number" name="minutes_cartons_equipe1_libre[]" class="form-input w-1/4" placeholder="Minute">' +
                '<button type="button" class="remove-carton bg-red-500 text-white px-2 rounded">X</button>';
            document.getElementById('cartons-equipe1-list').appendChild(div);
        });
    }
    // Ajouter carton équipe 2 (libre)
    const btnAddCarton2Libre = document.getElementById('add-carton-equipe2-libre');
    if (btnAddCarton2Libre) {
        btnAddCarton2Libre.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2 carton-row';
            div.innerHTML = '<input type="text" name="cartons_equipe2_libre[]" class="form-input w-1/2" placeholder="Nom (libre)">' +
                '<select name="type_cartons_equipe2_libre[]" class="form-select w-1/4"><option value="jaune">Jaune</option><option value="rouge">Rouge</option></select>' +
                '<input type="number" name="minutes_cartons_equipe2_libre[]" class="form-input w-1/4" placeholder="Minute">' +
                '<button type="button" class="remove-carton bg-red-500 text-white px-2 rounded">X</button>';
            document.getElementById('cartons-equipe2-list').appendChild(div);
        });
    }
    // Validation JS score/buteurs avant soumission
    document.querySelector('form').addEventListener('submit', function(e) {
        const score1 = parseInt(document.querySelector('input[name="score_equipe1"]').value) || 0;
        const score2 = parseInt(document.querySelector('input[name="score_equipe2"]').value) || 0;
        const buteurs1 = document.querySelectorAll('#buteurs-equipe1-list .buteur-row').length;
        const buteurs2 = document.querySelectorAll('#buteurs-equipe2-list .buteur-row').length;
        let msg = '';
        if (score1 !== buteurs1) {
            msg += `Le nombre de buteurs pour l'équipe 1 doit être égal au score saisi.\n`;
        }
        if (score2 !== buteurs2) {
            msg += `Le nombre de buteurs pour l'équipe 2 doit être égal au score saisi.`;
        }
        if (msg) {
            alert(msg);
            e.preventDefault();
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/admin/rencontres/edit_resultat.blade.php ENDPATH**/ ?>