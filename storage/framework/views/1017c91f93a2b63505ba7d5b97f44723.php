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
                <li><?php echo e($but->joueur?->nom); ?> <?php echo e($but->joueur?->prenom); ?> (<?php echo e($but->minute); ?>') -
                    <?php if($but->equipe_id == $rencontre->equipe1?->id): ?>
                        <?php echo e($rencontre->equipe1?->nom); ?>

                    <?php elseif($but->equipe_id == $rencontre->equipe2?->id): ?>
                        <?php echo e($rencontre->equipe2?->nom); ?>

                    <?php elseif($but->equipe_libre_nom): ?>
                        <?php echo e($but->equipe_libre_nom); ?>

                    <?php else: ?>
                        Équipe inconnue
                    <?php endif; ?>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li>Aucun</li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="section">
        <strong>Cartons :</strong>
        <ul>
            <?php $__empty_1 = true; $__currentLoopData = $rencontre->cartons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carton): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li><?php echo e($carton->joueur?->nom); ?> <?php echo e($carton->joueur?->prenom); ?> (<?php echo e($carton->minute); ?>') - <?php echo e(ucfirst($carton->type)); ?> -
                    <?php if($carton->equipe_id == $rencontre->equipe1?->id): ?>
                        <?php echo e($rencontre->equipe1?->nom); ?>

                    <?php elseif($carton->equipe_id == $rencontre->equipe2?->id): ?>
                        <?php echo e($rencontre->equipe2?->nom); ?>

                    <?php elseif($carton->equipe_libre_nom): ?>
                        <?php echo e($carton->equipe_libre_nom); ?>

                    <?php else: ?>
                        Équipe inconnue
                    <?php endif; ?>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li>Aucun</li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="section">
        <strong>Homme du match :</strong>
        <?php if($rencontre->mvp): ?>
            <?php echo e($rencontre->mvp->nom); ?> <?php echo e($rencontre->mvp->prenom); ?>

            (
            <?php if($rencontre->mvp->equipe?->nom): ?>
                <?php echo e($rencontre->mvp->equipe->nom); ?>

            <?php elseif($rencontre->mvp_libre_equipe): ?>
                <?php echo e($rencontre->mvp_libre_equipe); ?>

            <?php else: ?>
                Équipe inconnue
            <?php endif; ?>
            )
        <?php elseif($rencontre->mvp_libre): ?>
            <?php echo e($rencontre->mvp_libre); ?> (<?php echo e($rencontre->mvp_libre_equipe ?? 'Équipe inconnue'); ?>)
        <?php else: ?>
            -
        <?php endif; ?>
    </div>
    <div class="section">
        <strong>Effectifs :</strong>
        <div style="display: flex; gap: 40px;">
            <?php
                $effectifs = $rencontre->matchEffectifs ?? collect();
            ?>
            <?php $__currentLoopData = [$rencontre->equipe1, $rencontre->equipe2]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $effectif = $effectifs->where('equipe_id', $equipe->id)->first();
                    $joueurs = $effectif && $effectif->joueurs ? $effectif->joueurs : collect();
                    $remplacements = $effectif && $effectif->remplacements ? $effectif->remplacements : collect();
                ?>
                <div style="min-width: 260px;">
                    <div style="font-weight:bold; color:#e2001a; margin-bottom:4px;"><?php echo e($equipe->nom); ?></div>
                    <?php if(!$effectif): ?>
                        <div style="color:#888; font-style:italic; margin-bottom:12px;">Aucun effectif saisi pour cette équipe.</div>
                    <?php else: ?>
                        <div style="margin-bottom:2px; text-decoration:underline;">Titulaires</div>
                        <ul style="margin-bottom:6px;">
                            <?php $__currentLoopData = $joueurs->where('type','titulaire'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $effJoueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    N°<?php echo e($effJoueur->joueur?->numero_dossard ?? '-'); ?>

                                    <?php echo e($effJoueur->joueur?->nom); ?> <?php echo e($effJoueur->joueur?->prenom); ?>

                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <div style="margin-bottom:2px; text-decoration:underline;">Remplaçants</div>
                        <ul style="margin-bottom:6px;">
                            <?php $__currentLoopData = $joueurs->where('type','remplacant'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $effJoueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    N°<?php echo e($effJoueur->joueur?->numero_dossard ?? '-'); ?>

                                    <?php echo e($effJoueur->joueur?->nom); ?> <?php echo e($effJoueur->joueur?->prenom); ?>

                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <div style="margin-bottom:2px; text-decoration:underline;">Remplacements</div>
                        <ul>
                            <?php $__currentLoopData = $remplacements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    N°<?php echo e($remp->remplaçant?->numero_dossard ?? '-'); ?> <?php echo e($remp->remplaçant?->nom); ?> <?php echo e($remp->remplaçant?->prenom); ?>

                                    &rarr; N°<?php echo e($remp->remplacé?->numero_dossard ?? '-'); ?> <?php echo e($remp->remplacé?->nom); ?> <?php echo e($remp->remplacé?->prenom); ?>

                                    (<?php echo e($remp->minute); ?>')
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <div style="margin-top:40px; text-align:center;">
        <div style="font-size:13px; font-weight:bold; letter-spacing:2px; color:#e2001a; border-top:2px dashed #e2001a; width:60%; margin:0 auto 8px auto; padding-top:8px;">
            Comité exécutif
        </div>
        <div style="font-size:11px; color:#888;">Signature officielle</div>
        <div style="margin: 8px auto 0 auto; width: 120px; height: 40px;">
            <!-- Signature SVG stylisée -->
            <svg viewBox="0 0 120 40" width="120" height="40">
                <path d="M10,30 Q30,10 50,30 Q70,50 110,10" stroke="#222" stroke-width="2" fill="none"/>
                <text x="60" y="35" text-anchor="middle" font-size="12" fill="#444" font-family="cursive">EUFLU</text>
            </svg>
        </div>
        <?php if($rencontre->updatedBy): ?>
            <div style="font-size:11px; color:#888; margin-top:8px;">Dernière modification par : <span style="font-weight:bold;"><?php echo e($rencontre->updatedBy->name); ?></span></div>
        <?php endif; ?>
        <div style="margin-top:18px; font-size:10px; color:#aaa; letter-spacing:1px;">
            Document généré automatiquement - toute falsification est interdite. QR code ou filigrane possible sur demande.
        </div>
    </div>
    <style>
        body { background: repeating-linear-gradient(135deg, #f8f8f8, #f8f8f8 20px, #e2001a10 22px, #f8f8f8 40px); }
        .header { text-shadow: 1px 1px 0 #e2001a, 2px 2px 0 #fff; letter-spacing: 2px; }
        .section strong { color: #e2001a; }
        ul { list-style: square inside; }
        li { margin-bottom: 2px; }
    </style>
</body>
</html>
<?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/public/match/pdf.blade.php ENDPATH**/ ?>