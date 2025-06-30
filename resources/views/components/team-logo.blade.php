@props(['team', 'size' => 48])

@php
    // Récupère le chemin du logo si présent
    $logo = $team->logo ?? null;
    // Génère les initiales (premières lettres de chaque mot du nom)
    $initials = collect(explode(' ', $team->nom ?? $team->name ?? ''))
        ->filter()
        ->map(fn($w) => mb_substr($w, 0, 1))
        ->join('');
@endphp

@if($logo)
    <img src="{{ asset('storage/'.$logo) }}" alt="Logo {{ $team->nom ?? $team->name }}" style="width:{{ $size }}px;height:{{ $size }}px;object-fit:cover;border-radius:50%;background:#fff;border:1px solid #eee;" loading="lazy">
@elseif($initials)
    <div style="width:{{ $size }}px;height:{{ $size }}px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:#e5e7eb;color:#374151;font-weight:600;font-size:{{ $size/2 }}px;border:1px solid #eee;">
        {{ $initials }}
    </div>
@else
    <div style="width:{{ $size }}px;height:{{ $size }}px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:#f3f4f6;color:#9ca3af;font-size:{{ $size/2 }}px;border:1px solid #eee;">
        ?
    </div>
@endif
