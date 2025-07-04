@props([
    'article',
    'excerptLength' => 120,
    'showExcerpt' => true,
    'imgHeight' => 'h-48',
    'rounded' => '', // pas d'arrondi
    'shadow' => '', // pas d'ombre
    'border' => '', // pas de bordure sur la card principale
    'class' => ''
])
<div class="bg-[#23272a] p-0 flex flex-col overflow-hidden {{ $class }} cursor-pointer group" onclick="window.location='{{ route('public.articles.show', $article->id) }}'">
    @php
        $imgCount = $article->images?->count() ?? 0;
        $img = $article->images->first() ?? null;
        $hasVideo = $article->video;
    @endphp
    @if($hasVideo)
        <div class="w-full {{ $imgHeight }} relative" id="carousel-card-{{ $article->id }}">
            <video controls class="w-full h-full object-cover bg-black" style="min-height:120px;" onclick="event.stopPropagation();openMediaModal('video', `{{ asset('storage/' . $article->video) }}`)">
                <source src="{{ asset('storage/' . $article->video) }}" type="video/mp4">
                Votre navigateur ne supporte pas la lecture vidéo.
            </video>
        </div>
    @elseif($imgCount > 1)
        <div id="carousel-card-{{ $article->id }}" class="relative w-full {{ $imgHeight }} group" data-carousel>
            <div class="overflow-hidden w-full h-full relative">
                @foreach($article->images as $i => $img)
                    <img src="{{ asset('storage/' . $img->path) }}" alt="Image article" class="w-full h-full object-cover absolute inset-0 transition-all duration-700 ease-in-out {{ $imgHeight }} {{ $i === 0 ? '' : 'hidden' }} cursor-pointer" data-carousel-item onclick="event.stopPropagation();openMediaModal('image', `{{ asset('storage/' . $img->path) }}`)" />
                @endforeach
            </div>
            <button type="button" aria-label="Précédent" class="absolute top-1/2 left-2 -translate-y-1/2 bg-white/90 hover:bg-blue-100 rounded-full p-1 shadow opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10" data-carousel-prev onclick="event.stopPropagation();">
                <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            </button>
            <button type="button" aria-label="Suivant" class="absolute top-1/2 right-2 -translate-y-1/2 bg-white/90 hover:bg-blue-100 rounded-full p-1 shadow opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10" data-carousel-next onclick="event.stopPropagation();">
                <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </button>
            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1 z-10">
                @foreach($article->images as $i => $img)
                    <button type="button" aria-label="Aller à l'image {{ $i+1 }}" class="w-2 h-2 rounded-full border-2 border-blue-400 bg-white transition-all duration-300" style="opacity: {{ $i === 0 ? '1' : '0.5' }};" data-carousel-indicator onclick="event.stopPropagation();"></button>
                @endforeach
            </div>
        </div>
    @elseif($img)
        <div class="w-full {{ $imgHeight }} relative">
            <img src="{{ asset('storage/' . $img->path) }}" alt="Image article" class="w-full h-full object-cover" style="min-height:120px;" onerror="this.style.display='none'" onclick="event.stopPropagation();openMediaModal('image', `{{ asset('storage/' . $img->path) }}`)" />
        </div>
    @else
        <div class="flex items-center justify-center w-full {{ $imgHeight }} bg-[#23272a] text-[#e2001a] text-5xl font-extrabold select-none" style="min-height:120px;">
            {{ mb_substr($article->titre,0,1) }}
        </div>
    @endif
    <div class="flex flex-col flex-1 p-4">
        <h2 class="text-lg font-extrabold mb-1 text-white line-clamp-2 leading-tight">{{ $article->titre }}</h2>
        <div class="text-xs text-[#6fcf97] font-semibold mb-2 uppercase tracking-wider">{{ $article->type ?? 'Article' }} • {{ $article->saison->nom ?? '-' }}</div>
        @if($showExcerpt)
            <div class="mb-2 text-gray-300 text-sm line-clamp-3">{!! Str::limit(strip_tags($article->contenu), $excerptLength) !!}</div>
        @endif
        <div class="mt-auto flex justify-between items-end pt-2">
            <a href="{{ route('public.articles.show', $article->id) }}" class="text-[#e2001a] font-bold hover:underline text-sm" onclick="event.stopPropagation();">Lire la suite</a>
            <span class="text-xs text-gray-500">par {{ $article->user->name ?? '-' }}</span>
        </div>
    </div>
</div>
