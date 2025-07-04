@extends('layouts.public')
@section('title', $article->titre)
@section('content')
@php
    $imgCount = $article->images?->count() ?? 0;
@endphp
<div class="container mx-auto py-8 max-w-3xl">
    <div class="bg-gradient-to-br from-[#23272a] via-[#181d1f] to-[#10181c] rounded-2xl shadow-2xl p-8 border border-[#31363a] relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none select-none opacity-10" style="background:url('/storage/img_euflu/fecofa.png') center/40% no-repeat;"></div>
        <div class="mb-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 drop-shadow">{{ $article->titre }}</h1>
                    <div class="flex flex-wrap gap-2 text-sm text-gray-300 items-center">
                        <span class="bg-blue-900/80 text-blue-200 px-2 py-1 rounded text-xs font-semibold">{{ $article->type ?? 'Article' }}</span>
                        <span class="bg-gray-800/80 text-gray-200 px-2 py-1 rounded text-xs">{{ $article->saison->nom ?? '-' }}</span>
                        <span class="bg-green-900/80 text-green-200 px-2 py-1 rounded text-xs">{{ $article->created_at->format('d/m/Y') }}</span>
                        <span class="text-xs text-gray-400">par {{ $article->user->name ?? '-' }}</span>
                    </div>
                </div>
            </div>
            @if($article->video || ($article->images && $article->images->count()))
                <div id="carousel-{{ $article->id }}" data-carousel class="relative w-full h-80 md:h-[28rem] rounded-xl overflow-hidden shadow-lg mb-8 bg-black">
                    @if($article->video)
                        <div data-carousel-item class="w-full h-80 md:h-[28rem] relative">
                            <video src="{{ asset('storage/' . $article->video) }}" class="w-full h-80 md:h-[28rem] object-cover object-center rounded-xl" autoplay muted loop playsinline controls></video>
                            <a href="{{ asset('storage/' . $article->video) }}" download class="absolute bottom-4 left-4 bg-white text-blue-700 px-3 py-1 rounded shadow hover:bg-blue-100 z-10" title="Télécharger">⬇️ Télécharger</a>
                            <button onclick="openMediaModal('video', '{{ asset('storage/' . $article->video) }}')" class="absolute bottom-4 right-4 bg-white text-blue-700 px-3 py-1 rounded shadow hover:bg-blue-100 z-10" title="Zoom">🔍 Zoom</button>
                        </div>
                    @endif
                    @foreach($article->images as $img)
                        <div data-carousel-item class="w-full h-80 md:h-[28rem] relative">
                            <img src="{{ asset('storage/' . $img->path) }}" alt="Image article" class="w-full h-80 md:h-[28rem] object-cover object-center rounded-xl" />
                            <a href="{{ asset('storage/' . $img->path) }}" download class="absolute bottom-4 left-4 bg-white text-blue-700 px-3 py-1 rounded shadow hover:bg-blue-100 z-10" title="Télécharger">⬇️ Télécharger</a>
                            <button onclick="openMediaModal('image', '{{ asset('storage/' . $img->path) }}')" class="absolute bottom-4 right-4 bg-white text-blue-700 px-3 py-1 rounded shadow hover:bg-blue-100 z-10" title="Zoom">🔍 Zoom</button>
                        </div>
                    @endforeach
                    <button type="button" data-carousel-prev class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10 text-2xl">‹</button>
                    <button type="button" data-carousel-next class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10 text-2xl">›</button>
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                        @if($article->video)
                            <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-blue-400 bg-white transition-all duration-300 opacity-100"></button>
                        @endif
                        @foreach($article->images as $img)
                            <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-blue-400 bg-white transition-all duration-300 opacity-50"></button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="prose dark:prose-invert max-w-none text-lg leading-relaxed mb-8 text-white">
            {!! $article->contenu !!}
        </div>
        <div class="mt-8 flex gap-4">
            <a href="{{ url()->previous() }}" class="inline-block bg-[#23272a] text-white font-bold px-6 py-2 rounded-full shadow hover:bg-[#6fcf97] hover:text-[#23272a] transition-all duration-300 font-inter">← Retour</a>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
// Carrousel auto-défilant moderne (images + vidéo)
const imgCount = {{ $imgCount ?? 0 }};
const hasVideo = @json(!empty($article->video));
document.addEventListener('DOMContentLoaded', function() {
    if (imgCount > 1 || hasVideo) {
        showCarouselItem({{ $article->id }}, 0);
        startCarouselAutoplay({{ $article->id }});
        const carousel = document.getElementById('carousel-{{ $article->id }}');
        if (carousel) {
            carousel.addEventListener('mouseenter', () => stopCarouselAutoplay({{ $article->id }}));
            carousel.addEventListener('mouseleave', () => startCarouselAutoplay({{ $article->id }}));
            carousel.querySelectorAll('button').forEach(btn => {
                btn.addEventListener('click', () => {
                    stopCarouselAutoplay({{ $article->id }});
                    setTimeout(() => startCarouselAutoplay({{ $article->id }}), 4000);
                });
            });
        }
    }
});
function showCarouselItem(id, target) {
    const items = document.querySelectorAll(`#carousel-${id} [data-carousel-item]`);
    const indicators = document.querySelectorAll(`#carousel-${id} [data-carousel-indicator]`);
    items.forEach((img, i) => {
        if (i === target) {
            img.classList.remove('hidden');
            indicators[i].style.opacity = 1;
        } else {
            img.classList.add('hidden');
            indicators[i].style.opacity = 0.5;
        }
    });
}
function carouselNext(id) {
    const items = document.querySelectorAll(`#carousel-${id} [data-carousel-item]`);
    let idx = Array.from(items).findIndex(img => !img.classList.contains('hidden'));
    idx = (idx + 1) % items.length;
    showCarouselItem(id, idx);
}
function carouselPrev(id) {
    const items = document.querySelectorAll(`#carousel-${id} [data-carousel-item]`);
    let idx = Array.from(items).findIndex(img => !img.classList.contains('hidden'));
    idx = (idx - 1 + items.length) % items.length;
    showCarouselItem(id, idx);
}
function carouselGoTo(id, target) {
    showCarouselItem(id, target);
}
let carouselIntervals = {};
function startCarouselAutoplay(id) {
    stopCarouselAutoplay(id);
    carouselIntervals[id] = setInterval(() => {
        carouselNext(id);
    }, 3000);
}
function stopCarouselAutoplay(id) {
    if (carouselIntervals[id]) {
        clearInterval(carouselIntervals[id]);
        delete carouselIntervals[id];
    }
}
function openMediaModal(type, src) {
    let modal = document.getElementById('media-modal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'media-modal';
        modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80';
        modal.innerHTML = `
            <div class="relative max-w-3xl w-full flex flex-col items-center">
                <button onclick="closeMediaModal()" class="absolute top-2 right-2 bg-white text-gray-800 rounded-full p-2 shadow hover:bg-gray-200 z-10">✕</button>
                <div id="media-modal-content" class="w-full flex justify-center items-center"></div>
            </div>
        `;
        document.body.appendChild(modal);
    }
    const content = modal.querySelector('#media-modal-content');
    let downloadBtn = '';
    let zoomBtn = '';
    if (type === 'image') {
        downloadBtn = `<a href="${src}" download class='absolute bottom-4 left-4 bg-white text-blue-700 px-3 py-1 rounded shadow hover:bg-blue-100 z-10' title='Télécharger'>⬇️ Télécharger</a>`;
        zoomBtn = `<button onclick='zoomMediaModal()' class='absolute bottom-4 right-4 bg-white text-blue-700 px-3 py-1 rounded shadow hover:bg-blue-100 z-10' title='Zoom'>🔍 Zoom</button>`;
        content.innerHTML = `<div class='relative w-full flex justify-center items-center'><img id='media-modal-img' src="${src}" class="max-h-[80vh] max-w-full rounded shadow-lg" />${downloadBtn}${zoomBtn}</div>`;
    } else if (type === 'video') {
        downloadBtn = `<a href="${src}" download class='absolute bottom-4 left-4 bg-white text-blue-700 px-3 py-1 rounded shadow hover:bg-blue-100 z-10' title='Télécharger'>⬇️ Télécharger</a>`;
        zoomBtn = `<button onclick='zoomMediaModal()' class='absolute bottom-4 right-4 bg-white text-blue-700 px-3 py-1 rounded shadow hover:bg-blue-100 z-10' title='Zoom'>🔍 Zoom</button>`;
        content.innerHTML = `<div class='relative w-full flex justify-center items-center'><video id='media-modal-video' src="${src}" controls autoplay class="max-h-[80vh] max-w-full rounded shadow-lg"></video>${downloadBtn}${zoomBtn}</div>`;
    }
    modal.style.display = 'flex';
}
function closeMediaModal() {
    const modal = document.getElementById('media-modal');
    if (modal) modal.style.display = 'none';
}
function zoomMediaModal() {
    const img = document.getElementById('media-modal-img');
    const vid = document.getElementById('media-modal-video');
    if (img && img.requestFullscreen) img.requestFullscreen();
    if (vid && vid.requestFullscreen) vid.requestFullscreen();
}
</script>
@endsection
