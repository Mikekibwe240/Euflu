<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Feuille de match</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        .header { text-align: center; font-weight: bold; font-size: 20px; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .table th, .table td { border: 1px solid #333; padding: 5px; text-align: left; }
        .table th { background: #eee; }
    </style>
</head>
<body>
    <div class="header">Feuille de match</div>
    <div class="section">
        <strong>Match :</strong> <?php echo e($rencontre->equipe1->nom); ?> vs <?php echo e($rencontre->equipe2->nom); ?><br>
        <strong>Date :</strong> <?php echo e($rencontre->date); ?><br>
        <strong>Heure :</strong> <?php echo e($rencontre->heure); ?><br>
        <strong>Stade :</strong> <?php echo e($rencontre->stade); ?><br>
        <strong>Journée :</strong> <?php echo e($rencontre->journee); ?><br>
        <strong>Pool :</strong> <?php echo e($rencontre->pool?->nom ?? '-'); ?><br>
    </div>
    <div class="section">
        <strong>Score :</strong> <?php echo e($rencontre->score_equipe1 ?? '-'); ?> - <?php echo e($rencontre->score_equipe2 ?? '-'); ?>

    </div>
    <div class="section">
        <strong>Buteurs :</strong>
        <ul>
            <?php $__empty_1 = true; $__currentLoopData = $rencontre->buts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $but): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li><?php echo e($but->joueur?->nom); ?> <?php echo e($but->joueur?->prenom); ?> (<?php echo e($but->minute); ?>') - <?php echo e($but->equipe_id == $rencontre->equipe1?->id ? $rencontre->equipe1?->nom : $rencontre->equipe2?->nom); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li>Aucun</li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="section">
        <strong>Cartons :</strong>
        <ul>
            <?php $__empty_1 = true; $__currentLoopData = $rencontre->cartons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carton): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li><?php echo e($carton->joueur?->nom); ?> <?php echo e($carton->joueur?->prenom); ?> (<?php echo e($carton->minute); ?>') - <?php echo e(ucfirst($carton->type)); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li>Aucun</li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="section">
        <strong>Homme du match :</strong> <?php echo e($rencontre->mvp?->nom ?? '-'); ?>

    </div>
</body>
</html>
<?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/public/match/pdf.blade.php ENDPATH**/ ?>