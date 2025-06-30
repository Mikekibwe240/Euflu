@props(['type' => 'info', 'message' => null])

@php
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
@endphp

<div class="mb-4 p-3 rounded shadow flex items-center gap-2 {{ $color }}">
    <span class="text-xl">{!! $icon !!}</span>
    <span class="flex-1">{!! $message ?? $slot !!}</span>
</div>
