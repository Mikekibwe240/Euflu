@extends('layouts.public')

@section('title', 'Accueil Bundesliga Style')

@section('content')
@php
    use App\Models\Article;
    use App\Models\Rencontre;
    use Illuminate\Support\Str;
    use App\Models\Saison;
    use App\Helpers\SaisonHelper;
    $article = Article::orderByDesc('published_at')->first();
    $saison = SaisonHelper::getActiveSaison();
    $poules = $saison ? \App\Models\Pool::where('saison_id', $saison->id)->with(['equipes', 'equipes.statsSaison' => function($q) use ($saison) { $q->where('saison_id', $saison->id); }])->get() : collect();
    $sponsors = [
        '4201730-removebg-preview.png',
        'equity-bank-logo.png',
        'lubumbasi.png',
        'ministre_des_hydrocarbures_cover.jpeg',
        'rawbank.webp',
    ];
    $derniers_resultats = Rencontre::with(['equipe1', 'equipe2'])
        ->whereNotNull('score_equipe1')
        ->whereNotNull('score_equipe2')
        ->orderByDesc('date')
        ->limit(5)
        ->get();
    $prochains_matchs = Rencontre::with(['equipe1', 'equipe2'])
        ->where(function($q){
            $q->whereNull('score_equipe1')->orWhereNull('score_equipe2');
        })
        ->where('date', '>=', now())
        ->orderBy('date')
        ->limit(5)
        ->get();
    $derniers_articles = Article::with(['images', 'user'])
        ->orderByDesc('published_at')
        ->where('id', '!=', $article?->id)
        ->limit(5)
        ->get();
    if (!function_exists('makeAbbreviation')) {
        function makeAbbreviation($name) {
            $words = preg_split('/\s+/', trim($name));
            if (count($words) === 1) {
                return mb_strtoupper(mb_substr($name, 0, 3));
            }
            $abbr = '';
            foreach ($words as $w) {
                if (mb_strlen($w) > 0 && preg_match('/[A-Za-zÀ-ÿ]/u', $w)) {
                    $abbr .= mb_strtoupper(mb_substr($w, 0, 1));
                }
            }
            return $abbr;
        }
    }
@endphp
<div class="w-full bg-[#10181c] min-h-screen pb-12">
    <div class="max-w-6xl mx-auto px-2 sm:px-4 md:px-6 lg:px-0">
        <!-- HERO SECTION -->
        <div class="w-full aspect-[16/9] h-64 md:h-96 bg-[#181d1f] rounded-none overflow-hidden relative mt-0 mb-8" style="max-height:340px; min-height:160px;">
            @php
                $mediaList = collect();
                if ($article) {
                    if ($article->video) {
                        $mediaList->push(['type' => 'video', 'src' => asset('storage/' . $article->video)]);
                    }
                    if ($article->images && $article->images->count()) {
                        foreach ($article->images as $img) {
                            $mediaList->push(['type' => 'image', 'src' => asset('storage/' . $img->path)]);
                        }
                    }
                }
            @endphp
            @if($mediaList->count() > 0)
                <div data-carousel class="relative w-full h-full">
                    @foreach($mediaList as $i => $media)
                        @if($media['type'] === 'video')
                            <div data-carousel-item class="absolute inset-0 w-full h-full {{ $i !== 0 ? 'hidden' : '' }}">
                                <video class="w-full h-full object-cover object-center rounded bg-black" controls poster="https://placehold.co/1200x520?text=EUFLU" autoplay muted loop playsinline>
                                    <source src="{{ $media['src'] }}">
                                    Votre navigateur ne supporte pas la vidéo.
                                </video>
                            </div>
                        @else
                            <div data-carousel-item class="absolute inset-0 w-full h-full {{ $i !== 0 ? 'hidden' : '' }}">
                                <img src="{{ $media['src'] }}" alt="Image à la une" class="w-full h-full object-cover object-center rounded bg-black">
                            </div>
                        @endif
                    @endforeach
                    @if($mediaList->count() > 1)
                        <button type="button" data-carousel-prev class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10 text-2xl">‹</button>
                        <button type="button" data-carousel-next class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10 text-2xl">›</button>
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                            @foreach($mediaList as $i => $media)
                                <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-blue-400 bg-white transition-all duration-300 {{ $i === 0 ? 'opacity-100' : 'opacity-50' }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <img src="https://placehold.co/1200x520?text=EUFLU" alt="Image à la une" class="w-full h-full object-cover object-center">
            @endif
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 to-transparent p-6 md:p-8" style="max-height:170px; min-height:120px;">
                <h2 class="text-2xl md:text-3xl font-extrabold text-white mb-2 uppercase leading-tight line-clamp-2">{{ $article ? $article->titre : 'Aucune actualité' }}</h2>
                <p class="text-white text-base font-medium max-w-2xl line-clamp-2">{!! $article ? Str::limit(strip_tags($article->contenu), 110) : '' !!}</p>
                <div class="text-gray-400 text-xs mt-2">{{ $article && $article->published_at ? \Illuminate\Support\Carbon::parse($article->published_at)->format('d.m.Y') : '' }}</div>
            </div>
        </div>
        <!-- PARTNERS SECTION -->
        <div class="w-full bg-[#23272a] border-t border-[#31363a] px-0 py-6 md:py-8 mb-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-sm md:text-base text-gray-300 font-light tracking-widest uppercase text-left mb-4 md:mb-6 pl-1 md:pl-4"
                    style="letter-spacing:0.08em;">
                    PARTENAIRES OFFICIELS DE L'EUFLU <span class="font-bold text-white">PARTENAIRES</span>
                </div>
                <div class="relative">
                    <div id="sponsors-carousel" class="flex flex-nowrap items-center gap-x-8 md:gap-x-16 gap-y-4 md:gap-y-8 mt-2 whitespace-nowrap scroll-smooth overflow-x-hidden select-none scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-900 py-2 md:py-0" onwheel="event.preventDefault();">
                        @foreach($sponsors as $sponsor)
                            <img src="{{ asset('storage/img_euflu/sponsors/' . $sponsor) }}" alt="Sponsor" class="h-14 max-w-[140px] object-contain grayscale-0 inline-block" loading="lazy">
                        @endforeach
                        @foreach($sponsors as $sponsor) {{-- duplication pour boucle infinie --}}
                            <img src="{{ asset('storage/img_euflu/sponsors/' . $sponsor) }}" alt="Sponsor" class="h-14 max-w-[140px] object-contain grayscale-0 inline-block" loading="lazy">
                        @endforeach
                    </div>
                    {{-- Suppression des boutons de navigation manuel --}}
                </div>
            </div>
        </div>
        <!-- TABLE SECTION -->
        @if($saison && $poules->count())
            <div class="w-full mb-8">
                <div class="text-xl md:text-2xl font-extrabold text-white tracking-widest mb-4 md:mb-8 uppercase text-center" style="letter-spacing:0.08em;">
                    CLASSEMENTS
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                    @foreach($poules as $poule)
                        <div class="bg-[#181d1f] border-t-4 border-[#23272a] rounded-lg shadow p-3 md:p-4 mb-6 md:mb-8">
                            <div class="text-sm md:text-base font-extrabold text-white tracking-widest mb-1 md:mb-2 uppercase flex items-center gap-2 pl-1 md:pl-2">
                                <span class="text-[#e2001a]">POOL {{ strtoupper($poule->nom) }}</span>
                            </div>
                            <div class="relative">
                                <div id="classement-carousel-{{ $poule->id }}" class="flex flex-nowrap gap-4 md:gap-6 py-4 md:py-6 px-0 whitespace-nowrap scroll-smooth overflow-x-auto scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-900">
                                    @php
                                        $classement = $poule->equipes->map(function($eq) use ($saison) {
                                            $stats = $eq->statsSaison($saison->id)->first();
                                            return (object) [
                                                'equipe' => $eq,
                                                'points' => $stats?->points ?? 0,
                                            ];
                                        })->sortByDesc('points')->values();
                                    @endphp
                                    @if($classement->count() > 0)
                                        @foreach($classement as $i => $row)
                                            <div class="flex flex-col items-center justify-center min-w-[90px] md:min-w-[110px] max-w-[90px] md:max-w-[110px] h-[180px] md:h-[240px] bg-[#23272a] text-center relative shadow-md border border-[#23282d] cursor-pointer" style="border-radius:0; flex: 0 0 90px;" onclick="window.location='{{ route('equipes.show', ['equipe' => $row->equipe->id]) }}'">
                                                <div class="text-base md:text-lg text-gray-400 font-bold mb-1 md:mb-2 mt-2 md:mt-4">{{ $i+1 }}.</div>
                                                <div class="flex items-center justify-center h-10 md:h-16 mb-2 md:mb-4">
                                                    <x-team-logo :team="$row->equipe" :size="36" />
                                                </div>
                                                <div class="font-extrabold text-base md:text-xl uppercase text-white mb-1 md:mb-2">{{ $row->equipe->abbreviation ?? makeAbbreviation($row->equipe->nom) }}</div>
                                                <div class="text-sm md:text-base text-gray-400 font-bold">{{ $row->points }}Pts</div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-gray-400 italic py-6 md:py-8 px-2 md:px-4">Aucune équipe dans cette pool</div>
                                    @endif
                                </div>
                                <button id="classement-prev-{{ $poule->id }}" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10 text-xl md:text-2xl">‹</button>
                                <button id="classement-next-{{ $poule->id }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10 text-xl md:text-2xl">›</button>
                                <div class="flex justify-end mt-2 md:mt-4 pr-2 md:pr-4">
                                    <a href="/classement?poule={{ urlencode($poule->nom) }}" class="font-extrabold uppercase text-base md:text-lg tracking-wider transition px-3 md:px-6 py-1.5 md:py-2 rounded shadow" style="color:#e2001a; border:none; background:transparent;" onmouseover="this.style.color='#b80015'" onmouseout="this.style.color='#e2001a'">VOIR LE CLASSEMENT COMPLET &rarr;</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <!-- SECTION DERNIERS ARTICLES -->
        <div class="w-full mb-8">
            <div class="flex items-center mb-2 md:mb-4">
                <h3 class="text-base md:text-lg font-bold text-[#e2001a] uppercase tracking-wider">Plus d'actualités</h3>
            </div>
            @php
                $articles = $derniers_articles->take(5);
            @endphp
            <div class="flex flex-col gap-4 md:gap-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    @foreach($articles->take(2) as $a)
                        @php
                            $mediaList = collect();
                            if ($a->video) {
                                $mediaList->push(['type' => 'video', 'src' => asset('storage/' . $a->video)]);
                            }
                            if ($a->images && $a->images->count()) {
                                foreach ($a->images as $img) {
                                    $mediaList->push(['type' => 'image', 'src' => asset('storage/' . $img->path)]);
                                }
                            }
                        @endphp
                        <div class="bg-[#23272a] rounded-xl shadow-lg border border-[#313a3a] p-3 md:p-4 flex flex-col hover:bg-[#181d1f] transition group min-w-0 h-[420px] md:h-[540px]">
                            @if($mediaList->count() > 0)
                                <div id="carousel-card-{{ $a->id }}" class="relative w-full aspect-[16/8] bg-[#181d1f] overflow-hidden mb-4" data-carousel-card>
                                    @foreach($mediaList as $i => $media)
                                        @if($media['type'] === 'video')
                                            <div data-carousel-item class="absolute inset-0 w-full h-full {{ $i !== 0 ? 'hidden' : '' }}">
                                                <video class="w-full h-full object-cover object-center rounded bg-black" controls poster="https://placehold.co/600x340?text=EUFLU" autoplay muted loop playsinline>
                                                    <source src="{{ $media['src'] }}">
                                                    Votre navigateur ne supporte pas la vidéo.
                                                </video>
                                            </div>
                                        @else
                                            <div data-carousel-item class="absolute inset-0 w-full h-full {{ $i !== 0 ? 'hidden' : '' }}">
                                                <img src="{{ $media['src'] }}" alt="Image article" class="w-full h-full object-cover object-center rounded bg-black" />
                                            </div>
                                        @endif
                                    @endforeach
                                    @if($mediaList->count() > 1)
                                        <button type="button" data-carousel-prev class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10">‹</button>
                                        <button type="button" data-carousel-next class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10">›</button>
                                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                                            @foreach($mediaList as $i => $media)
                                                <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-blue-400 bg-white transition-all duration-300 {{ $i === 0 ? 'opacity-100' : 'opacity-50' }}"></button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <x-article-card :article="$a" :imgHeight="null" class="flex-1 min-w-0" />
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                    @foreach($articles->skip(2)->take(3) as $a)
                        @php
                            $mediaList = collect();
                            if ($a->video) {
                                $mediaList->push(['type' => 'video', 'src' => asset('storage/' . $a->video)]);
                            }
                            if ($a->images && $a->images->count()) {
                                foreach ($a->images as $img) {
                                    $mediaList->push(['type' => 'image', 'src' => asset('storage/' . $img->path)]);
                                }
                            }
                        @endphp
                        <div class="bg-[#23272a] rounded-xl shadow-lg border border-[#313a3a] p-3 md:p-4 flex flex-col hover:bg-[#181d1f] transition group min-w-0 h-[320px] md:h-[420px]">
                            @if($mediaList->count() > 0)
                                <div id="carousel-card-{{ $a->id }}" class="relative w-full aspect-[16/8] bg-[#181d1f] overflow-hidden mb-4" data-carousel-card>
                                    @foreach($mediaList as $i => $media)
                                        @if($media['type'] === 'video')
                                            <div data-carousel-item class="absolute inset-0 w-full h-full {{ $i !== 0 ? 'hidden' : '' }}">
                                                <video class="w-full h-full object-cover object-center rounded bg-black" controls poster="https://placehold.co/600x340?text=EUFLU" autoplay muted loop playsinline>
                                                    <source src="{{ $media['src'] }}">
                                                    Votre navigateur ne supporte pas la vidéo.
                                                </video>
                                            </div>
                                        @else
                                            <div data-carousel-item class="absolute inset-0 w-full h-full {{ $i !== 0 ? 'hidden' : '' }}">
                                                <img src="{{ $media['src'] }}" alt="Image article" class="w-full h-full object-cover object-center rounded bg-black" />
                                            </div>
                                        @endif
                                    @endforeach
                                    @if($mediaList->count() > 1)
                                        <button type="button" data-carousel-prev class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10">‹</button>
                                        <button type="button" data-carousel-next class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-blue-100 rounded-full p-2 shadow z-10">›</button>
                                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                                            @foreach($mediaList as $i => $media)
                                                <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-blue-400 bg-white transition-all duration-300 {{ $i === 0 ? 'opacity-100' : 'opacity-50' }}"></button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <x-article-card :article="$a" :imgHeight="null" class="flex-1 min-w-0" />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-end mt-2 md:mt-4">
                <a href="/articles" class="text-[#6fcf97] font-bold hover:underline text-sm md:text-base">Voir toutes les actualités &rarr;</a>
            </div>
        </div>
        <!-- SECTIONS DERNIERS RESULTATS & PROCHAINS MATCHS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 mb-8">
            <div class="bg-[#23272a] rounded-lg shadow p-4 md:p-6 border border-[#313a3f]">
                <div class="flex items-center justify-between mb-2 md:mb-4">
                    <h3 class="text-base md:text-lg font-bold text-[#6fcf97] uppercase tracking-wider">Derniers résultats</h3>
                    <a href="/matchs?statut=joue" class="text-[#e2001a] font-bold hover:underline text-xs md:text-sm">Voir plus &rarr;</a>
                </div>
                <ul class="divide-y divide-[#313a3f]">
                    @forelse($derniers_resultats as $match)
                        <a href="{{ route('public.match.show', $match->id) }}" class="block hover:bg-[#181d1f] transition rounded">
                            <li class="py-2 md:py-3 flex flex-wrap md:flex-nowrap items-center justify-between gap-2">
                                <span class="flex items-center gap-2 font-bold text-white min-w-[80px] md:min-w-[100px] max-w-[120px] md:max-w-[160px] truncate">
                                    <x-team-logo :team="$match->equipe1" :size="24" />
                                    <span class="truncate">{{ $match->equipe1->nom ?? '?' }}</span>
                                </span>
                                <span class="text-lg md:text-xl font-extrabold text-[#e2001a] mx-2">{{ $match->score_equipe1 }} - {{ $match->score_equipe2 }}</span>
                                <span class="flex items-center gap-2 font-bold text-white min-w-[80px] md:min-w-[100px] max-w-[120px] md:max-w-[160px] truncate">
                                    <x-team-logo :team="$match->equipe2" :size="24" />
                                    <span class="truncate">{{ $match->equipe2->nom ?? '?' }}</span>
                                </span>
                                <span class="text-xs text-gray-400 ml-2 md:ml-4 w-20 md:w-32 truncate text-right">{{ \Carbon\Carbon::parse($match->date)->format('d/m/Y') }}</span>
                            </li>
                        </a>
                    @empty
                        <li class="text-gray-400 italic">Aucun résultat récent</li>
                    @endforelse
                </ul>
            </div>
            <div class="bg-[#23272a] rounded-lg shadow p-4 md:p-6 border border-[#313a3f]">
                <div class="flex items-center justify-between mb-2 md:mb-4">
                    <h3 class="text-base md:text-lg font-bold text-[#6fcf97] uppercase tracking-wider">Prochains matchs</h3>
                    <a href="/matchs?statut=non%20joue" class="text-[#e2001a] font-bold hover:underline text-xs md:text-sm">Voir plus &rarr;</a>
                </div>
                <ul>
                    @forelse($prochains_matchs as $match)
                        <a href="{{ route('public.match.show', $match->id) }}" class="block hover:bg-[#181d1f] transition">
                            <li class="py-2 md:py-3 flex flex-wrap md:flex-nowrap items-center justify-between gap-2">
                                <span class="flex items-center gap-2 font-bold text-white min-w-[80px] md:min-w-[100px] max-w-[120px] md:max-w-[160px] truncate">
                                    <x-team-logo :team="$match->equipe1" :size="24" />
                                    <span class="truncate">{{ $match->equipe1->nom ?? '?' }}</span>
                                </span>
                                <span class="text-lg md:text-xl font-extrabold text-[#e2001a] mx-2 md:mx-4 flex-shrink-0">vs</span>
                                <span class="flex items-center gap-2 font-bold text-white min-w-[80px] md:min-w-[100px] max-w-[120px] md:max-w-[160px] truncate">
                                    <x-team-logo :team="$match->equipe2" :size="24" />
                                    <span class="truncate">{{ $match->equipe2->nom ?? '?' }}</span>
                                </span>
                                <span class="text-xs text-gray-400 ml-2 md:ml-4 flex-shrink-0 text-right w-20 md:w-32 truncate">
                                    {{ \Carbon\Carbon::parse($match->date)->format('d/m/Y') }}
                                    @if($match->heure)
                                        {{ ' ' . $match->heure }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </li>
                        </a>
                    @empty
                        <li class="text-gray-400 italic">Aucun match à venir</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Suppression des scripts carrousel pour les articles --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('[EUFLU] Carousel script loaded'); // Debug: vérifier que le JS s’exécute
    // Carousel principal (hero) et carrousels articles
    document.querySelectorAll('[data-carousel], [data-carousel-card]').forEach(function(carousel) {
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
            btn.onclick = () => showSlide(i);
        });
        let nextBtn = carousel.querySelector('[data-carousel-next]');
        let prevBtn = carousel.querySelector('[data-carousel-prev]');
        if (nextBtn) nextBtn.onclick = nextSlide;
        if (prevBtn) prevBtn.onclick = prevSlide;
        showSlide(0);
        // Correction: éviter plusieurs intervalles
        function startInterval() {
            if (interval) clearInterval(interval);
            interval = setInterval(nextSlide, 4000);
        }
        function stopInterval() {
            if (interval) clearInterval(interval);
            interval = null;
        }
        if (slides.length > 1) {
            startInterval();
            carousel.addEventListener('mouseenter', stopInterval);
            carousel.addEventListener('mouseleave', startInterval);
        }
    });
    // Carrousel partenaires (logos)
    const carousel = document.getElementById('sponsors-carousel');
    if (carousel) {
        // Empêche le scroll horizontal manuel à la souris
        carousel.addEventListener('wheel', function(e) {
            e.preventDefault();
        }, { passive: false });
        let scrollAmount = 1;
        function getMaxScroll() {
            return carousel.scrollWidth / 2;
        }
        function autoScroll() {
            if (carousel.scrollLeft >= getMaxScroll()) {
                carousel.scrollLeft = 0;
            } else {
                carousel.scrollLeft += scrollAmount;
            }
        }
        let interval = setInterval(autoScroll, 20);
        function startInterval() {
            if (interval) clearInterval(interval);
            interval = setInterval(autoScroll, 20);
        }
        function stopInterval() {
            if (interval) clearInterval(interval);
            interval = null;
        }
        carousel.addEventListener('mouseenter', stopInterval);
        carousel.addEventListener('mouseleave', startInterval);
    }
});
</script>
@endpush
