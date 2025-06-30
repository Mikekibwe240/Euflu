@extends('layouts.public')
@section('title', $article->titre)
@section('content')
<div class="container mx-auto py-8 max-w-3xl">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">{{ $article->titre }}</h1>
        <div class="mb-4 flex flex-wrap gap-2 text-sm text-gray-600 dark:text-gray-300 items-center">
            <span class="bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-200 px-2 py-1 rounded text-xs font-semibold">{{ $article->type ?? 'Article' }}</span>
            <span class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-2 py-1 rounded text-xs">{{ $article->saison->nom ?? '-' }}</span>
            <span class="bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-200 px-2 py-1 rounded text-xs">{{ $article->created_at->format('d/m/Y') }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400">par {{ $article->user->name ?? '-' }}</span>
        </div>
        @php $hasVideo = $article->video; $imgCount = $article->images?->count() ?? 0; @endphp
        @if($hasVideo)
            <div class="mb-4">
                <video controls autoplay muted loop playsinline class="w-full rounded shadow cursor-pointer bg-black dark:bg-gray-800 border border-gray-200 dark:border-gray-700" onclick="openMediaModal('video', `{{ asset('storage/' . $article->video) }}`)">
                    <source src="{{ asset('storage/' . $article->video) }}" type="video/mp4">
                    Votre navigateur ne supporte pas la lecture vidéo.
                </video>
            </div>
        @elseif($imgCount > 1)
            <div id="carousel-{{ $article->id }}" class="relative mb-4 group">
                <div class="overflow-hidden rounded-lg shadow h-64 relative bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                    @foreach($article->images as $i => $img)
                        <img src="{{ asset('storage/' . $img->path) }}" alt="Image article" class="w-full h-64 object-cover absolute inset-0 transition-all duration-700 ease-in-out {{ $i === 0 ? '' : 'hidden' }} cursor-pointer" data-carousel-item onclick="openMediaModal('image', `{{ asset('storage/' . $img->path) }}`)" />
                    @endforeach
                </div>
                <!-- Boutons navigation -->
                <button type="button" aria-label="Précédent" class="absolute top-1/2 left-2 -translate-y-1/2 bg-gray-900/90 dark:bg-gray-100/80 text-white dark:text-gray-900 rounded-full p-2 shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 font-inter" onclick="carouselPrev({{ $article->id }})">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <button type="button" aria-label="Suivant" class="absolute top-1/2 right-2 -translate-y-1/2 bg-gray-900/90 dark:bg-gray-100/80 text-white dark:text-gray-900 rounded-full p-2 shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 font-inter" onclick="carouselNext({{ $article->id }})">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </button>
                <!-- Indicateurs -->
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    @foreach($article->images as $i => $img)
                        <button type="button"
                                class="w-3 h-3 rounded-full bg-blue-400 dark:bg-blue-700 opacity-50 border-2 border-white dark:border-gray-700 transition-all duration-300"
                                data-carousel-indicator
                                aria-label="Aller à l'image {{ $i + 1 }}"
                                onclick="carouselGoTo({{ $article->id }}, {{ $i }})">
                        </button>
                    @endforeach
                </div>
            </div>
        @elseif($imgCount === 1)
            <img src="{{ asset('storage/' . $article->images->first()->path) }}" alt="Image article" class="w-full h-64 object-cover rounded mb-4 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 cursor-pointer" onerror="this.style.display='none'" onclick="openMediaModal('image', `{{ asset('storage/' . $article->images->first()->path) }}`)" />
        @endif
        <div class="prose dark:prose-invert max-w-none">
            {!! $article->contenu !!}
        </div>
        <div class="mt-8 flex gap-4">
            <a href="{{ url()->previous() }}" class="inline-block bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 font-bold px-6 py-2 rounded-full shadow hover:bg-primary-700 dark:hover:bg-gray-300 transition-all duration-300 font-inter">← Retour</a>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
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
document.addEventListener('DOMContentLoaded', function() {
    @if($imgCount > 1)
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
    @endif
});
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
