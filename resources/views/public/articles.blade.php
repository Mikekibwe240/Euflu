@extends('layouts.public')
@section('title', 'Actualités EUFLU')
{{-- Suppression de la section header pour rétablir le header global --}}
@section('content')
@php
    $featured = $articles->first();
    $others = $articles->slice(1);
@endphp
@if($featured)
    <div class="max-w-6xl mx-auto mt-6 mb-10">
        <div class="relative rounded-lg overflow-hidden shadow-lg">
            @if(($featured->images && $featured->images->count()) || $featured->video)
                <div data-carousel class="relative w-full h-72">
                    @if($featured->video)
                        <div data-carousel-item class="w-full h-72">
                            <video src="{{ asset('storage/' . $featured->video) }}" class="w-full h-72 object-cover object-center rounded" autoplay muted loop playsinline></video>
                        </div>
                    @endif
                    @foreach($featured->images as $img)
                        <div data-carousel-item class="w-full h-72">
                            <img src="{{ asset('storage/' . $img->path) }}" alt="Image principale" class="w-full h-72 object-cover object-center rounded" />
                        </div>
                    @endforeach
                    <button type="button" data-carousel-prev class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10">‹</button>
                    <button type="button" data-carousel-next class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10">›</button>
                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                        @if($featured->video)
                            <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-blue-400 bg-white transition-all duration-300 opacity-100"></button>
                        @endif
                        @foreach($featured->images as $img)
                            <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-blue-400 bg-white transition-all duration-300 opacity-50"></button>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-transparent p-6">
                <div class="text-xs text-[#e2001a] font-bold uppercase mb-1">{{ strtoupper($featured->type ?? 'ACTUALITÉ') }} <span class="ml-2 text-gray-300 font-normal">{{ $featured->created_at->format('M d, Y') }}</span></div>
                <a href="{{ route('public.articles.show', $featured->id) }}" class="block">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 leading-tight">{{ $featured->titre }}</h1>
                </a>
                <div class="text-white text-base font-medium mb-2 line-clamp-3">{{ Str::limit(strip_tags($featured->contenu), 200) }}</div>
            </div>
        </div>
    </div>
@endif
<div class="max-w-6xl mx-auto mb-10">
    <h2 class="text-2xl font-extrabold text-white uppercase tracking-wider mb-6 mt-8">PLUS D'ACTUALITÉS</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($others as $article)
            <a href="{{ route('public.articles.show', $article->id) }}" class="block group">
                <div class="flex flex-col md:flex-row bg-[#181d1f] rounded-lg shadow-lg overflow-hidden border border-[#23272a] transition hover:shadow-xl hover:border-[#e2001a]">
                    @if(($article->images && $article->images->count()) || $article->video)
                        <div class="md:w-1/3 w-full h-48 md:h-auto flex-shrink-0 relative">
                            <div data-carousel class="relative w-full h-48 md:h-64">
                                @if($article->video)
                                    <div data-carousel-item class="w-full h-48 md:h-64">
                                        <video src="{{ asset('storage/' . $article->video) }}" class="w-full h-48 md:h-64 object-cover object-center rounded" autoplay muted loop playsinline></video>
                                    </div>
                                @endif
                                @foreach($article->images as $img)
                                    <div data-carousel-item class="w-full h-48 md:h-64">
                                        <img src="{{ asset('storage/' . $img->path) }}" alt="Image article" class="w-full h-48 md:h-64 object-cover object-center rounded" />
                                    </div>
                                @endforeach
                                <button type="button" data-carousel-prev class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10">‹</button>
                                <button type="button" data-carousel-next class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10">›</button>
                                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
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
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div>
                            <div class="text-xs text-[#e2001a] font-bold uppercase mb-1">{{ strtoupper($article->type ?? 'ACTUALITÉ') }} <span class="ml-2 text-gray-400 font-normal">{{ $article->created_at->format('M d, Y') }}</span></div>
                            <h3 class="text-xl font-bold text-white mb-2 leading-tight group-hover:text-[#e2001a]">{{ $article->titre }}</h3>
                            <div class="text-gray-300 text-sm mb-2 line-clamp-3">{{ Str::limit(strip_tags($article->contenu), 120) }}</div>
                        </div>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-xs text-gray-400">{{ $article->user->name ?? '' }}</span>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <div class="mt-8">
        {{ $articles->links() }}
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-carousel]').forEach(function(carousel) {
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
        function startAuto() {
            if (interval) clearInterval(interval);
            if (slides.length > 1) {
                interval = setInterval(nextSlide, 5000);
            }
        }
        function stopAuto() {
            if (interval) clearInterval(interval);
        }
        indicators.forEach((btn, i) => {
            btn.addEventListener('click', () => showSlide(i));
        });
        carousel.querySelector('[data-carousel-next]')?.addEventListener('click', nextSlide);
        carousel.querySelector('[data-carousel-prev]')?.addEventListener('click', prevSlide);
        showSlide(0);
        startAuto();
        carousel.addEventListener('mouseenter', stopAuto);
        carousel.addEventListener('mouseleave', startAuto);
        // Pour mobile : relancer l'auto après interaction
        carousel.addEventListener('touchend', startAuto);
    });
});
</script>
@endpush
