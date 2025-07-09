<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Équipes</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #888; padding: 6px 8px; text-align: center; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Liste des Équipes</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Pool</th>
                <th>Coach</th>
                <th>Saison</th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $equipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($equipe->nom); ?></td>
                <td><?php echo e($equipe->pool->nom ?? '-'); ?></td>
                <td><?php echo e($equipe->coach); ?></td>
                <td><?php echo e($equipe->saison->nom ?? ($equipe->saison->annee ?? '-')); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/exports/equipes_pdf.blade.php ENDPATH**/ ?>