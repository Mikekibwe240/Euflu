<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['team', 'size' => 48]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['team', 'size' => 48]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    // Récupère le chemin du logo si présent
    $logo = $team->logo ?? null;
    // Génère les initiales (premières lettres de chaque mot du nom)
    $initials = collect(explode(' ', $team->nom ?? $team->name ?? ''))
        ->filter()
        ->map(fn($w) => mb_substr($w, 0, 1))
        ->join('');
?>

<?php if($logo): ?>
    <img src="<?php echo e(asset('storage/'.$logo)); ?>" alt="Logo <?php echo e($team->nom ?? $team->name); ?>" style="width:<?php echo e($size); ?>px;height:<?php echo e($size); ?>px;object-fit:cover;border-radius:50%;background:#fff;border:1px solid #eee;" loading="lazy">
<?php elseif($initials): ?>
    <div style="width:<?php echo e($size); ?>px;height:<?php echo e($size); ?>px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:#e5e7eb;color:#374151;font-weight:600;font-size:<?php echo e($size/2); ?>px;border:1px solid #eee;">
        <?php echo e($initials); ?>

    </div>
<?php else: ?>
    <div style="width:<?php echo e($size); ?>px;height:<?php echo e($size); ?>px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:#f3f4f6;color:#9ca3af;font-size:<?php echo e($size/2); ?>px;border:1px solid #eee;">
        ?
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/components/team-logo.blade.php ENDPATH**/ ?>