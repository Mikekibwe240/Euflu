<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['type' => 'info', 'message' => null]));

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

foreach (array_filter((['type' => 'info', 'message' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $colors = [
        'success' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        'error' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
    ];
    $icons = [
        'success' => '✔️',
        'error' => '❌',
        'warning' => '⚠️',
        'info' => 'ℹ️',
    ];
    $color = $colors[$type] ?? $colors['info'];
    $icon = $icons[$type] ?? $icons['info'];
?>

<div class="mb-4 p-3 rounded shadow flex items-center gap-2 <?php echo e($color); ?>">
    <span class="text-xl"><?php echo $icon; ?></span>
    <span class="flex-1"><?php echo $message ?? $slot; ?></span>
</div>
<?php /**PATH C:\Users\MIKE KIBWE\Documents\Learning\UDBL\L4 GL\TFC\Application\Euflu\resources\views/components/alert.blade.php ENDPATH**/ ?>