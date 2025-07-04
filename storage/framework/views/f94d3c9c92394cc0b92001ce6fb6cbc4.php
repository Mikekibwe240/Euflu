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
?>

<?php if($logo): ?>
    <img src="<?php echo e(asset('storage/'.$logo)); ?>" alt="Logo <?php echo e($team->nom ?? $team->name); ?>" style="width:<?php echo e($size); ?>px;height:<?php echo e($size); ?>px;object-fit:cover;border-radius:50%;background:#fff;border:1px solid #eee;" loading="lazy">
<?php else: ?>
    <span style="width:<?php echo e($size); ?>px;height:<?php echo e($size); ?>px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:#23272a;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="#e2001a" viewBox="0 0 24 24" style="height:<?php echo e($size*0.7); ?>px;width:<?php echo e($size*0.7); ?>px;">
            <circle cx="12" cy="12" r="10" fill="#23272a"/>
            <path d="M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z" fill="#e2001a"/>
            <circle cx="12" cy="12" r="3" fill="#fff"/>
        </svg>
    </span>
<?php endif; ?>
<?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/components/team-logo.blade.php ENDPATH**/ ?>