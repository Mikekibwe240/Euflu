
<?php $__env->startSection('title', 'Joueurs'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto py-8 px-2 sm:px-4 md:px-6 lg:px-0">
    <h1 class="text-2xl md:text-3xl font-extrabold mb-6 text-white uppercase tracking-wider">Tous les joueurs de la ligue</h1>
    <form method="GET" class="flex flex-wrap gap-2 md:gap-4 items-center mb-6 md:mb-8">
        <select name="saison_id" class="px-3 md:px-4 py-2 rounded text-black bg-white border-2 border-[#e2001a] focus:outline-none focus:ring-2 focus:ring-[#e2001a] min-w-[120px] md:min-w-[160px] text-sm md:text-base" onchange="this.form.submit()">
            <option value="all" <?php echo e(($saison_id ?? $activeSaison?->id) === 'all' ? 'selected' : ''); ?>>Toutes les saisons</option>
            <?php $__currentLoopData = $saisons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s->id); ?>" <?php echo e((string)($saison_id ?? $activeSaison?->id) == (string)$s->id ? 'selected' : ''); ?>><?php echo e($s->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="equipe_id" class="px-3 md:px-4 py-2 rounded text-black bg-white border-2 border-[#e2001a] focus:outline-none focus:ring-2 focus:ring-[#e2001a] min-w-[120px] md:min-w-[160px] text-sm md:text-base" onchange="this.form.submit()">
            <option value="">Toutes les équipes</option>
            <option value="libre" <?php echo e(request('equipe_id') === 'libre' ? 'selected' : ''); ?>>Libres (sans équipe)</option>
            <?php $__currentLoopData = $equipes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($equipe->id); ?>" <?php echo e(request('equipe_id') == $equipe->id ? 'selected' : ''); ?>><?php echo e($equipe->nom); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <input type="text" name="nom" value="<?php echo e(request('nom')); ?>" placeholder="Nom, prénom..." class="px-3 md:px-4 py-2 rounded border-2 border-[#e2001a] focus:outline-none focus:ring-2 focus:ring-[#e2001a] min-w-[120px] md:min-w-[180px] text-sm md:text-base bg-white text-black placeholder-gray-500" />
        <button type="submit" class="px-4 md:px-5 py-2 bg-gradient-to-r from-[#e2001a] to-[#b80016] text-white font-extrabold rounded shadow-lg hover:from-[#b80016] hover:to-[#e2001a] focus:outline-none focus:ring-2 focus:ring-[#e2001a] transition text-sm md:text-base">Rechercher</button>
    </form>
    <?php
        $totalJoueurs = $groupedJoueurs->flatten(2)->count();
    ?>
    <?php if($totalJoueurs === 0): ?>
        <?php
            $activeFilters = collect([
                request('saison_id') && request('saison_id') !== 'all' ? 'Saison' : null,
                request('equipe_id') ? (request('equipe_id') === 'libre' ? 'Libres' : 'Équipe') : null,
                request('nom') ? 'Nom' : null,
            ])->filter()->implode(', ');
        ?>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded">
            Aucun joueur n'a été trouvé pour votre recherche.
            <?php if($activeFilters): ?>
                <br><span class="font-semibold">Filtres actifs :</span> <?php echo e($activeFilters); ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php if(isset($clubSelected) && $clubSelected): ?>
        <div class="text-xl font-bold text-[#e2001a] mb-4 flex items-center gap-2">
            <?php if($clubSelected->logo): ?>
                <img src="<?php echo e(asset('storage/' . $clubSelected->logo)); ?>" alt="Logo" class="h-8 w-8 rounded-full bg-white inline-block">
            <?php else: ?>
                <span class="h-8 w-8 flex items-center justify-center rounded-full bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#e2001a" viewBox="0 0 24 24" class="h-6 w-6">
                        <circle cx="12" cy="12" r="10" fill="#23272a"/>
                        <path d="M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z" fill="#e2001a"/>
                        <circle cx="12" cy="12" r="3" fill="#fff"/>
                    </svg>
                </span>
            <?php endif; ?>
            <?php echo e($clubSelected->nom); ?>

        </div>
    <?php endif; ?>
    <?php
        $postes = [
            'Gardien' => ['GK', 'Gardien', 'Goalkeeper'],
            'Défenseur' => ['DEF', 'Défenseur', 'Defender'],
            'Milieu' => ['MIL', 'Milieu', 'Midfielder'],
            'Attaquant' => ['ATT', 'Attaquant', 'Forward', 'Striker'],
        ];
    ?>
    <?php $__currentLoopData = $postes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $posteLabel => $aliases): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $joueursPoste = $groupedJoueurs->filter(function($group, $poste) use ($aliases) {
                return in_array($poste, $aliases);
            })->flatten(1);
        ?>
        <?php if($joueursPoste->count()): ?>
            <div class="mt-6 md:mt-8">
                <h2 class="text-base md:text-lg font-bold text-gray-300 uppercase mb-3 md:mb-4"><?php echo e(strtoupper($posteLabel)); ?></h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 md:gap-4 min-w-0">
                    <?php $__currentLoopData = $joueursPoste; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(url('/joueurs/'.$joueur->id)); ?>" class="bg-[#181d1f] hover:bg-[#23272a] rounded-lg p-3 md:p-4 shadow transition cursor-pointer border border-[#23272a] flex items-center gap-3 md:gap-4 min-w-0">
                            <?php if($joueur->photo): ?>
                                <img src="<?php echo e(asset('storage/'.$joueur->photo)); ?>" alt="Photo" class="h-10 w-10 md:h-12 md:w-12 rounded-full object-cover bg-gray-700">
                            <?php else: ?>
                                <div class="h-10 w-10 md:h-12 md:w-12 rounded-full bg-gray-700 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-8 w-8 md:h-10 md:w-10">
                                        <circle cx="12" cy="12" r="10" fill="#23272a"/>
                                        <path d="M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z" fill="#e2001a"/>
                                        <circle cx="12" cy="12" r="3" fill="#fff"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            <div class="flex-1 min-w-0">
                                <div class="font-bold text-white text-base md:text-lg truncate"><?php echo e($joueur->nom); ?> <span class="font-normal"><?php echo e($joueur->prenom); ?></span></div>
                                <div class="text-xs md:text-sm text-gray-400 truncate"><?php echo e($joueur->equipe?->nom ?? 'Libre'); ?></div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php
        $autres = $groupedJoueurs->filter(function($group, $poste) use ($postes) {
            foreach($postes as $aliases) if(in_array($poste, $aliases)) return false;
            return true;
        })->flatten(1);
    ?>
    <?php if($autres->count()): ?>
        <div class="mt-8">
            <h2 class="text-lg font-bold text-gray-300 uppercase mb-4">JOUEURS</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php $__currentLoopData = $autres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $joueur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(url('/joueurs/'.$joueur->id)); ?>" class="bg-[#181d1f] hover:bg-[#23272a] rounded-lg p-4 shadow transition cursor-pointer border border-[#23272a] flex items-center gap-4">
                        <div>
                            <?php if($joueur->photo): ?>
                                <img src="<?php echo e(asset('storage/'.$joueur->photo)); ?>" alt="Photo" class="h-12 w-12 rounded-full object-cover bg-gray-700">
                            <?php else: ?>
                                <div class="h-12 w-12 rounded-full bg-gray-700 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-10 w-10">
                                        <circle cx="12" cy="8" r="4"/>
                                        <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-white text-lg"><?php echo e($joueur->nom); ?> <span class="font-normal"><?php echo e($joueur->prenom); ?></span></div>
                            <div class="text-gray-400 text-sm uppercase"><?php echo e($joueur->poste); ?></div>
                            <div class="text-gray-500 text-xs mt-1"><?php echo e($joueur->equipe?->nom); ?></div>
                            <div class="text-gray-400 text-xs mt-1 flex flex-col gap-0.5">
                                <span>Licence : <span class="font-mono"><?php echo e($joueur->numero_licence ?? '-'); ?></span></span>
                                <span>Dossard : <span class="font-mono"><?php echo e($joueur->numero_dossard ?? '-'); ?></span></span>
                                <span>Nationalité : <?php echo e($joueur->nationalite ?? '-'); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/public/joueurs.blade.php ENDPATH**/ ?>