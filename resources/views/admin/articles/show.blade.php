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
        @if($article->video)
            <div class="mb-4 flex justify-center">
                <video controls class="w-full max-w-lg rounded-xl shadow cursor-pointer" onclick="openMediaModal('video', '{{ asset('storage/' . $article->video) }}')">
                    <source src="{{ asset('storage/' . $article->video) }}" type="video/mp4">
                    Vidéo non supportée.
                </video>
            </div>
        @endif
        @if($imgCount > 1)
            <div id="carousel-admin-{{ $article->id }}" class="relative mb-4 group">
                <div class="overflow-hidden rounded-lg shadow h-64 relative">
                    @foreach($article->images as $i => $img)
                        <img src="{{ asset('storage/' . $img->path) }}" alt="Image article" class="w-full h-64 object-cover absolute inset-0 transition-all duration-700 ease-in-out {{ $i === 0 ? '' : 'hidden' }} cursor-pointer" data-carousel-item onclick="openMediaModal('image', '{{ asset('storage/' . $img->path) }}')" />
                    @endforeach
                </div>
                <button type="button" aria-label="Précédent" class="absolute top-1/2 left-2 -translate-y-1/2 bg-white/90 hover:bg-blue-100 dark:bg-gray-900/80 rounded-full p-2 shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10" onclick="carouselPrevAdmin({{ $article->id }})">
                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <button type="button" aria-label="Suivant" class="absolute top-1/2 right-2 -translate-y-1/2 bg-white/90 hover:bg-blue-100 dark:bg-gray-900/80 rounded-full p-2 shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10" onclick="carouselNextAdmin({{ $article->id }})">
                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </button>
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    @foreach($article->images as $i => $img)
                        <button type="button" aria-label="Aller à l'image {{ $i+1 }}" class="w-3 h-3 rounded-full border-2 border-blue-400 bg-white transition-all duration-300" style="opacity:{{ $i === 0 ? '1' : '0.5' }}" data-carousel-indicator onclick="carouselGoToAdmin({{ $article->id }}, {{ $i }})"></button>
                    @endforeach
                </div>
            </div>
        @elseif($imgCount === 1)
            <div class="mb-4 flex justify-center">
                <img src="{{ asset('storage/' . $article->images->first()->path) }}" alt="Image principale" class="rounded-xl max-w-full h-64 border border-gray-200 dark:border-gray-700 bg-white shadow" onerror="this.style.display='none'" />
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
@endsection
