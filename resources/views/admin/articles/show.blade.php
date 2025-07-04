@extends('layouts.admin')

@section('title', 'Fiche Article')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8 border border-blue-100 dark:border-blue-800">
        <div class="mb-4 flex items-center gap-4">
            <span class="inline-block bg-blue-600 text-white rounded-full px-4 py-1 font-bold text-lg shadow">N° {{ $article->id }}</span>
            <h1 class="text-3xl font-extrabold text-blue-800 dark:text-blue-200">{{ $article->titre }}</h1>
        </div>
        <div class="mb-2 text-gray-500 dark:text-gray-400 text-sm flex flex-wrap gap-2 items-center">
            <span class="bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-200 px-2 py-1 rounded text-xs font-semibold">Saison : {{ $article->saison->nom ?? $article->saison->annee ?? '-' }}</span>
            <span class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-2 py-1 rounded text-xs">Auteur : {{ $article->user->name ?? '-' }}</span>
            <span class="bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-200 px-2 py-1 rounded text-xs">Publié le : {{ $article->created_at->format('d/m/Y') }}</span>
        </div>
        <hr class="my-4 border-gray-200 dark:border-gray-700">
        <div class="prose dark:prose-invert max-w-none mb-4 text-lg leading-relaxed">
            {!! nl2br(e($article->contenu)) !!}
        </div>
        @php $imgCount = $article->images?->count() ?? 0; @endphp
        @if($article->video || ($article->images && $article->images->count()))
        <div class="mb-6">
            <div data-carousel class="relative w-full max-w-xl mx-auto rounded-xl overflow-hidden shadow bg-black">
                @if($article->video)
                    <div data-carousel-item class="w-full h-80 md:h-[28rem]">
                        <video src="{{ asset('storage/' . $article->video) }}" class="w-full h-80 md:h-[28rem] object-cover object-center rounded-xl" autoplay muted loop playsinline controls></video>
                    </div>
                @endif
                @foreach($article->images as $img)
                    <div data-carousel-item class="w-full h-80 md:h-[28rem]">
                        <img src="{{ asset('storage/' . $img->path) }}" class="w-full h-80 md:h-[28rem] object-cover object-center rounded-xl" />
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
        </div>
        @endif
        <div class="flex gap-2 mb-6">
            <a href="{{ route('admin.articles.edit', $article) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">Modifier</a>
            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cet article ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">Supprimer</button>
            </form>
            <a href="{{ route('admin.articles.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow ml-auto">← Retour à la liste</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showCarouselItemAdmin(id, target) {
    const items = document.querySelectorAll(`#carousel-admin-${id} [data-carousel-item]`);
    const indicators = document.querySelectorAll(`#carousel-admin-${id} [data-carousel-indicator]`);
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
function carouselNextAdmin(id) {
    const items = document.querySelectorAll(`#carousel-admin-${id} [data-carousel-item]`);
    let idx = Array.from(items).findIndex(img => !img.classList.contains('hidden'));
    if (idx === -1) idx = 0;
    idx = (idx + 1) % items.length;
    showCarouselItemAdmin(id, idx);
}
function carouselPrevAdmin(id) {
    const items = document.querySelectorAll(`#carousel-admin-${id} [data-carousel-item]`);
    let idx = Array.from(items).findIndex(img => !img.classList.contains('hidden'));
    if (idx === -1) idx = 0;
    idx = (idx - 1 + items.length) % items.length;
    showCarouselItemAdmin(id, idx);
}
function carouselGoToAdmin(id, target) {
    showCarouselItemAdmin(id, target);
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
    if (type === 'image') {
        content.innerHTML = `<img src="${src}" class="max-h-[80vh] max-w-full rounded shadow-lg" />`;
    } else if (type === 'video') {
        content.innerHTML = `<video src="${src}" controls autoplay class="max-h-[80vh] max-w-full rounded shadow-lg"></video>`;
    }
    modal.style.display = 'flex';
}
function closeMediaModal() {
    const modal = document.getElementById('media-modal');
    if (modal) modal.style.display = 'none';
}
document.addEventListener('DOMContentLoaded', function() {
    @if($imgCount > 1)
        showCarouselItemAdmin({{ $article->id }}, 0);
    @endif
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-carousel]')?.forEach(function(carousel) {
        let slides = carousel.querySelectorAll('[data-carousel-item]');
        let indicators = carousel.querySelectorAll('[data-carousel-indicator]');
        let current = 0;
        let interval = null;
        function showSlide(idx) {
            slides.forEach((el, i) => {
                el.classList.toggle('hidden', i !== idx);
                if (indicators[i]) indicators[i].style.opacity = (i === idx ? '1' : '0.5');
            });
            current = idx;
        }
        function nextSlide() {
            showSlide((current + 1) % slides.length);
        }
        function prevSlide() {
            showSlide((current - 1 + slides.length) % slides.length);
        }
        indicators.forEach((btn, i) => {
            btn.addEventListener('click', () => showSlide(i));
        });
        carousel.querySelector('[data-carousel-next]')?.addEventListener('click', nextSlide);
        carousel.querySelector('[data-carousel-prev]')?.addEventListener('click', prevSlide);
        showSlide(0);
        interval = setInterval(nextSlide, 5000);
        carousel.addEventListener('mouseenter', () => clearInterval(interval));
        carousel.addEventListener('mouseleave', () => interval = setInterval(nextSlide, 5000));
    });
});
</script>
@endsection
