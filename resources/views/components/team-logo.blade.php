@props(['team', 'size' => 48])

@php
    // Récupère le chemin du logo si présent
    $logo = $team->logo ?? null;
@endphp

@if($logo)
    <img src="{{ asset('storage/'.$logo) }}" alt="Logo {{ $team->nom ?? $team->name }}" style="width:{{ $size }}px;height:{{ $size }}px;object-fit:cover;border-radius:50%;background:#fff;border:1px solid #eee;" loading="lazy">
@else
    <span style="width:{{ $size }}px;height:{{ $size }}px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:#23272a;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="#e2001a" viewBox="0 0 24 24" style="height:{{ $size*0.7 }}px;width:{{ $size*0.7 }}px;">
            <circle cx="12" cy="12" r="10" fill="#23272a"/>
            <path d="M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z" fill="#e2001a"/>
            <circle cx="12" cy="12" r="3" fill="#fff"/>
        </svg>
    </span>
@endif
