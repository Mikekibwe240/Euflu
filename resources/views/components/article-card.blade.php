@props([
    'article',
    'excerptLength' => 120,
    'showExcerpt' => true,
    'imgHeight' => 'h-48',
    'rounded' => 'rounded-xl',
    'shadow' => 'shadow-lg',
    'border' => 'border border-gray-200 dark:border-gray-700',
    'class' => ''
])
<div class="bg-white dark:bg-gray-900 {{ $rounded }} {{ $shadow }} p-4 flex flex-col h-full {{ $border }} {{ $class }}">
    @php
        $imgCount = $article->images?->count() ?? 0;
        $img = $article->images->first() ?? null;
        $hasVideo = $article->video;
    @endphp
    @if($hasVideo)
        <video controls class="w-full {{ $imgHeight }} {{ $rounded }} {{ $border }} bg-black cursor-pointer" onclick="openMediaModal('video', `{{ asset('storage/' . $article->video) }}`)">
            <source src="{{ asset('storage/' . $article->video) }}" type="video/mp4">
            Votre navigateur ne supporte pas la lecture vidéo.
        </video>
    @elseif($imgCount > 1)
        <div id="carousel-card-{{ $article->id }}" class="relative w-full h-full group">
            <div class="overflow-hidden {{ $rounded }} {{ $imgHeight }} relative">
                @foreach($article->images->take(3) as $i => $img)
                    <img src="{{ asset('storage/' . $img->path) }}" alt="Image article" class="w-full object-cover absolute inset-0 transition-all duration-700 ease-in-out {{ $imgHeight }} {{ $rounded }} {{ $border }} bg-white {{ $i === 0 ? '' : 'hidden' }} cursor-pointer" data-carousel-item onclick="openMediaModal('image', `{{ asset('storage/' . $img->path) }}`)" />
                @endforeach
            </div>
            <button type="button" aria-label="Précédent" class="absolute top-1/2 left-2 -translate-y-1/2 bg-white/90 hover:bg-blue-100 dark:bg-gray-900/80 rounded-full p-1 shadow opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10" onclick="carouselPrevCard({{ $article->id }})">
                <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            </button>
            <button type="button" aria-label="Suivant" class="absolute top-1/2 right-2 -translate-y-1/2 bg-white/90 hover:bg-blue-100 dark:bg-gray-900/80 rounded-full p-1 shadow opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10" onclick="carouselNextCard({{ $article->id }})">
                <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </button>
            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1 z-10">
                @foreach($article->images->take(3) as $i => $img)
                    <button type="button" aria-label="Aller à l'image {{ $i+1 }}" class="w-2 h-2 rounded-full border-2 border-blue-400 bg-white transition-all duration-300" style="opacity:{{ $i === 0 ? '1' : '0.5' }}" data-carousel-indicator onclick="carouselGoToCard({{ $article->id }}, {{ $i }})"></button>
                @endforeach
            </div>
        </div>
    @elseif($img)
        <img src="{{ asset('storage/' . $img->path) }}" alt="Image article" class="w-full object-cover {{ $imgHeight }} {{ $rounded }} {{ $border }} bg-white cursor-pointer" onerror="this.style.display='none'" onclick="openMediaModal('image', `{{ asset('storage/' . $img->path) }}`)" />
    @else
        <div class="flex items-center justify-center w-full {{ $imgHeight }} {{ $rounded }} {{ $border }} bg-white text-blue-700 dark:text-blue-300 text-5xl font-bold select-none">
            {{ mb_substr($article->titre,0,1) }}
        </div>
    @endif
    <h2 class="text-xl font-bold mb-2 text-blue-700 dark:text-blue-300 line-clamp-2">{{ $article->titre }}</h2>
    <div class="text-sm text-gray-500 dark:text-gray-400 mb-2 flex flex-wrap gap-2 items-center">
        <span class="bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-200 px-2 py-1 rounded text-xs font-semibold">{{ $article->type ?? 'Article' }}</span>
        <span class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-2 py-1 rounded text-xs">{{ $article->saison->nom ?? '-' }}</span>
        <span class="bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-200 px-2 py-1 rounded text-xs">{{ $article->created_at->format('d/m/Y') }}</span>
    </div>
    @if($showExcerpt)
        <div class="mb-2 text-gray-700 dark:text-gray-200 line-clamp-3">{!! Str::limit(strip_tags($article->contenu), $excerptLength) !!}</div>
    @endif
    <div class="mt-auto flex justify-between items-end">
        <a href="{{ route('public.articles.show', $article->id) }}" class="text-blue-700 dark:text-blue-300 font-bold hover:underline">Lire la suite</a>
        <span class="text-xs text-gray-500 dark:text-gray-400">par {{ $article->user->name ?? '-' }}</span>
    </div>
</div>
@section('scripts')
<script>
function carouselNextCard(id) {
    const items = document.querySelectorAll(`#carousel-card-${id} [data-carousel-item]`);
    const indicators = document.querySelectorAll(`#carousel-card-${id} [data-carousel-indicator]`);
    let idx = Array.from(items).findIndex(img => !img.classList.contains('hidden'));
    items[idx].classList.add('hidden');
    indicators[idx].style.opacity = 0.5;
    idx = (idx + 1) % items.length;
    items[idx].classList.remove('hidden');
    indicators[idx].style.opacity = 1;
}
function carouselPrevCard(id) {
    const items = document.querySelectorAll(`#carousel-card-${id} [data-carousel-item]`);
    const indicators = document.querySelectorAll(`#carousel-card-${id} [data-carousel-indicator]`);
    let idx = Array.from(items).findIndex(img => !img.classList.contains('hidden'));
    items[idx].classList.add('hidden');
    indicators[idx].style.opacity = 0.5;
    idx = (idx - 1 + items.length) % items.length;
    items[idx].classList.remove('hidden');
    indicators[idx].style.opacity = 1;
}
function carouselGoToCard(id, target) {
    const items = document.querySelectorAll(`#carousel-card-${id} [data-carousel-item]`);
    const indicators = document.querySelectorAll(`#carousel-card-${id} [data-carousel-indicator]`);
    let idx = Array.from(items).findIndex(img => !img.classList.contains('hidden'));
    items[idx].classList.add('hidden');
    indicators[idx].style.opacity = 0.5;
    items[target].classList.remove('hidden');
    indicators[target].style.opacity = 1;
}
function startCarouselCardAutoplay(id) {
    stopCarouselCardAutoplay(id);
    window['carouselCardInterval' + id] = setInterval(() => {
        carouselNextCard(id);
    }, 3000);
}
function stopCarouselCardAutoplay(id) {
    if (window['carouselCardInterval' + id]) {
        clearInterval(window['carouselCardInterval' + id]);
        window['carouselCardInterval' + id] = null;
    }
}
document.addEventListener('DOMContentLoaded', function() {
    @if(isset($article) && ($article->images?->count() ?? 0) > 1)
        startCarouselCardAutoplay({{ $article->id }});
        const carousel = document.getElementById('carousel-card-{{ $article->id }}');
        if (carousel) {
            carousel.addEventListener('mouseenter', () => stopCarouselCardAutoplay({{ $article->id }}));
            carousel.addEventListener('mouseleave', () => startCarouselCardAutoplay({{ $article->id }}));
            carousel.querySelectorAll('button').forEach(btn => {
                btn.addEventListener('click', () => {
                    stopCarouselCardAutoplay({{ $article->id }});
                    setTimeout(() => startCarouselCardAutoplay({{ $article->id }}), 4000);
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
        content.innerHTML = `<video controls class="max-h-[80vh] w-full rounded shadow-lg"><source src="${src}" type="video/mp4">Votre navigateur ne supporte pas la lecture vidéo.</video>`;
    }
    modal.style.display = 'flex';
}
function closeMediaModal() {
    const modal = document.getElementById('media-modal');
    if (modal) modal.style.display = 'none';
}
function zoomMediaModal() {
    const img = document.getElementById('media-modal-img');
    if (img && img.requestFullscreen) img.requestFullscreen();
}
</script>
@endsection
