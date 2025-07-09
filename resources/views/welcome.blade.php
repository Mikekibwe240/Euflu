@extends('layouts.public')

@section('title', 'Accueil EUFLU')

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
<div class="w-full bg-bl-dark min-h-screen pb-12">
    <div class="max-w-6xl mx-auto px-2 sm:px-4 md:px-6 lg:px-0">
        <!-- HERO SECTION -->
        <div class="w-full aspect-[16/9] h-64 md:h-96 bg-bl-card rounded-none overflow-hidden relative mt-0 mb-8" style="max-height:340px; min-height:160px;">
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
                        <button type="button" data-carousel-prev class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-bl-accent/80 rounded-full p-2 shadow z-10 text-2xl transition-colors">‹</button>
                        <button type="button" data-carousel-next class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-bl-accent/80 rounded-full p-2 shadow z-10 text-2xl transition-colors">›</button>
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                            @foreach($mediaList as $i => $media)
                                <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-bl-accent bg-white transition-all duration-300 {{ $i === 0 ? 'opacity-100' : 'opacity-50' }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <img src="https://placehold.co/1200x520?text=EUFLU" alt="Image à la une" class="w-full h-full object-cover object-center">
            @endif
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 to-transparent p-6 md:p-8" style="max-height:170px; min-height:120px;">
                <h2 class="text-2xl md:text-3xl font-extrabold text-white mb-2 uppercase leading-tight line-clamp-2 font-bundesliga tracking-widest drop-shadow-lg">{{ $article ? $article->titre : 'Aucune actualité' }}</h2>
                <p class="text-white text-base font-medium max-w-2xl line-clamp-2">{!! $article ? Str::limit(strip_tags($article->contenu), 110) : '' !!}</p>
                <div class="text-green-500 text-xs mt-2">{{ $article && $article->published_at ? \Illuminate\Support\Carbon::parse($article->published_at)->format('d.m.Y') : '' }}</div>
            </div>
        </div>
        <!-- PARTNERS SECTION -->
        <div class="w-full bg-bl-card border-t border-bl-border px-0 py-6 md:py-8 mb-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-sm md:text-base text-green-500 font-light tracking-widest uppercase text-left mb-4 md:mb-6 pl-1 md:pl-4 font-bundesliga"
                    style="letter-spacing:0.08em;">
                    PARTENAIRES OFFICIELS DE L'EUFLU <span class="font-bold text-white">PARTENAIRES</span>
                </div>
                <div class="relative">
                    <div id="sponsors-carousel" class="flex flex-nowrap items-center gap-x-8 md:gap-x-16 gap-y-4 md:gap-y-8 mt-2 whitespace-nowrap scroll-smooth overflow-x-auto select-none py-2 md:py-0" style="scrollbar-width: none; -ms-overflow-style: none;">
                        <style>
                            #sponsors-carousel::-webkit-scrollbar { display: none; }
                        </style>
                        @foreach($sponsors as $sponsor)
                            <img src="{{ asset('storage/img_euflu/sponsors/' . $sponsor) }}" alt="Sponsor" class="h-14 max-w-[140px] object-contain grayscale-0 inline-block transition-transform duration-300 hover:scale-110" loading="lazy">
                        @endforeach
                        @foreach($sponsors as $sponsor) {{-- duplication pour boucle infinie --}}
                            <img src="{{ asset('storage/img_euflu/sponsors/' . $sponsor) }}" alt="Sponsor" class="h-14 max-w-[140px] object-contain grayscale-0 inline-block transition-transform duration-300 hover:scale-110" loading="lazy">
                        @endforeach
                    </div>
                    {{-- Suppression des boutons de navigation manuel --}}
                </div>
            </div>
        </div>
        <!-- TABLE SECTION -->
        @if($saison && $poules->count())
            <div class="w-full mb-8">
                <div class="text-xl md:text-2xl font-extrabold text-white tracking-widest mb-4 md:mb-8 uppercase text-center font-bundesliga" style="letter-spacing:0.08em;">
                    CLASSEMENTS
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                    @foreach($poules as $poule)
                        <div class="bg-bl-card border-t-4 border-bl-border rounded-lg shadow p-3 md:p-4 mb-6 md:mb-8">
                            <div class="text-sm md:text-base font-extrabold text-green-500 tracking-widest mb-1 md:mb-2 uppercase flex items-center gap-2 pl-1 md:pl-2 font-bundesliga">
                                <span>POOL {{ strtoupper($poule->nom) }}</span>
                            </div>
                            <div class="relative">
                                <div id="classement-carousel-{{ $poule->id }}" class="flex flex-nowrap gap-4 md:gap-6 py-4 md:py-6 px-0 whitespace-nowrap scroll-smooth overflow-x-auto scrollbar-thin scrollbar-thumb-bl-border scrollbar-track-bl-card" style="scrollbar-width: none; -ms-overflow-style: none;" tabindex="-1">
                                    <style>
                                        #classement-carousel-{{ $poule->id }}::-webkit-scrollbar { display: none; }
                                    </style>
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
                                            <div class="flex flex-col items-center justify-center min-w-[90px] md:min-w-[110px] max-w-[90px] md:max-w-[110px] h-[180px] md:h-[240px] bg-bl-card text-center relative shadow-md border border-bl-border cursor-pointer hover:bg-bl-dark transition" style="border-radius:0; flex: 0 0 90px;" onclick="window.location='{{ route('equipes.show', ['equipe' => $row->equipe->id]) }}'">
                                                <div class="text-base md:text-lg text-bl-gray font-bold mb-1 md:mb-2 mt-2 md:mt-4">{{ $i+1 }}.</div>
                                                <div class="flex items-center justify-center h-10 md:h-16 mb-2 md:mb-4">
                                                    <x-team-logo :team="$row->equipe" :size="36" />
                                                </div>
                                                <div class="font-extrabold text-base md:text-xl uppercase text-white mb-1 md:mb-2 font-bundesliga tracking-widest">{{ $row->equipe->abbreviation ?? makeAbbreviation($row->equipe->nom) }}</div>
                                                <div class="text-sm md:text-base text-green-500 font-bold">{{ $row->points }}Pts</div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-bl-gray italic py-6 md:py-8 px-2 md:px-4">Aucune équipe dans cette pool</div>
                                    @endif
                                </div>
                                <button id="classement-prev-{{ $poule->id }}" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-bl-accent/80 rounded-full p-2 shadow z-10 text-xl md:text-2xl transition-colors">‹</button>
                                <button id="classement-next-{{ $poule->id }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-bl-accent/80 rounded-full p-2 shadow z-10 text-xl md:text-2xl transition-colors">›</button>
                                <div class="flex justify-end mt-2 md:mt-4 pr-2 md:pr-4">
                                    <a href="/classement?poule={{ urlencode($poule->nom) }}" class="font-extrabold uppercase text-base md:text-lg tracking-wider transition px-3 md:px-6 py-1.5 md:py-2 rounded shadow text-bl-accent hover:text-white hover:bg-bl-accent/90 font-bundesliga" style="border:none; background:transparent;">VOIR LE CLASSEMENT COMPLET &rarr;</a>
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
                <h3 class="text-base md:text-lg font-bold text-bl-accent uppercase tracking-wider font-bundesliga">Plus d'actualités</h3>
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
                        <div class="bg-bl-card rounded-xl shadow-lg border border-bl-border p-3 md:p-4 flex flex-col hover:bg-bl-dark transition group min-w-0 h-[420px] md:h-[540px]">
                            @if($mediaList->count() > 0)
                                <div id="carousel-card-{{ $a->id }}" class="relative w-full aspect-[16/8] bg-bl-dark overflow-hidden mb-4" data-carousel-card>
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
                                        <button type="button" data-carousel-prev class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-bl-accent/80 rounded-full p-2 shadow z-10 transition-colors">‹</button>
                                        <button type="button" data-carousel-next class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-bl-accent/80 rounded-full p-2 shadow z-10 transition-colors">›</button>
                                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                                            @foreach($mediaList as $i => $media)
                                                <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-bl-accent bg-white transition-all duration-300 {{ $i === 0 ? 'opacity-100' : 'opacity-50' }}"></button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <x-article-card :article="$a" :imgHeight="null" :showMedia="false" class="flex-1 min-w-0 font-bundesliga" />
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
                        <div class="bg-bl-card rounded-xl shadow-lg border border-bl-border p-3 md:p-4 flex flex-col hover:bg-bl-dark transition group min-w-0 h-[320px] md:h-[420px]">
                            @if($mediaList->count() > 0)
                                <div id="carousel-card-{{ $a->id }}" class="relative w-full aspect-[16/8] bg-bl-dark overflow-hidden mb-4" data-carousel-card>
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
                                        <button type="button" data-carousel-prev class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-bl-accent/80 rounded-full p-2 shadow z-10 transition-colors">‹</button>
                                        <button type="button" data-carousel-next class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-bl-accent/80 rounded-full p-2 shadow z-10 transition-colors">›</button>
                                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                                            @foreach($mediaList as $i => $media)
                                                <button type="button" data-carousel-indicator class="w-3 h-3 rounded-full border-2 border-bl-accent bg-white transition-all duration-300 {{ $i === 0 ? 'opacity-100' : 'opacity-50' }}"></button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <x-article-card :article="$a" :imgHeight="null" :showMedia="false" class="flex-1 min-w-0 font-bundesliga" />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-end mt-2 md:mt-4">
                <a href="/articles" class="text-bl-accent font-bold hover:underline text-sm md:text-base font-bundesliga">Voir toutes les actualités &rarr;</a>
            </div>
        </div>
        <!-- SECTIONS DERNIERS RESULTATS & PROCHAINS MATCHS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 mb-8">
            <div class="bg-bl-card rounded-lg shadow p-4 md:p-6 border border-bl-border">
                <div class="flex items-center justify-between mb-2 md:mb-4">
                    <h3 class="text-base md:text-lg font-bold text-bl-accent uppercase tracking-wider font-bundesliga">Derniers résultats</h3>
                    <a href="/matchs?statut=joue&order=desc" class="text-green-500 font-bold hover:underline text-xs md:text-sm font-bundesliga">Voir plus &rarr;</a>
                </div>
                <ul class="divide-y divide-bl-border">
                    @forelse($derniers_resultats as $match)
                        <a href="{{ route('public.match.show', $match->id) }}" class="block hover:bg-bl-dark transition rounded">
                            <li class="py-2 md:py-3 flex flex-wrap md:flex-nowrap items-center justify-between gap-2">
                                <span class="flex items-center gap-2 font-bold text-white min-w-[80px] md:min-w-[100px] max-w-[120px] md:max-w-[160px] truncate">
                                    <x-team-logo :team="$match->equipe1" :size="24" />
                                    <span class="truncate">{{ $match->equipe1->nom ?? '?' }}</span>
                                </span>
                                <span class="text-lg md:text-xl font-extrabold text-bl-accent mx-2 font-bundesliga">{{ $match->score_equipe1 }} - {{ $match->score_equipe2 }}</span>
                                <span class="flex items-center gap-2 font-bold text-white min-w-[80px] md:min-w-[100px] max-w-[120px] md:max-w-[160px] truncate">
                                    <x-team-logo :team="$match->equipe2" :size="24" />
                                    <span class="truncate">{{ $match->equipe2->nom ?? '?' }}</span>
                                </span>
                                <span class="text-xs text-bl-gray ml-2 md:ml-4 w-20 md:w-32 truncate text-right">{{ \Carbon\Carbon::parse($match->date)->format('d/m/Y') }}</span>
                            </li>
                        </a>
                    @empty
                        <li class="text-bl-gray italic">Aucun résultat récent</li>
                    @endforelse
                </ul>
            </div>
            <div class="bg-bl-card rounded-lg shadow p-4 md:p-6 border border-bl-border">
                <div class="flex items-center justify-between mb-2 md:mb-4">
                    <h3 class="text-base md:text-lg font-bold text-bl-accent uppercase tracking-wider font-bundesliga">Prochains matchs</h3>
                    <a href="/matchs?statut=non%20joue&order=asc" class="text-green-500 font-bold hover:underline text-xs md:text-sm font-bundesliga">Voir plus &rarr;</a>
                </div>
                <ul>
                    @forelse($prochains_matchs as $match)
                        <a href="{{ route('public.match.show', $match->id) }}" class="block hover:bg-bl-dark transition rounded">
                            <li class="py-2 md:py-3 flex flex-wrap md:flex-nowrap items-center justify-between gap-2">
                                <span class="flex items-center gap-2 font-bold text-white min-w-[80px] md:min-w-[100px] max-w-[120px] md:max-w-[160px] truncate">
                                    <x-team-logo :team="$match->equipe1" :size="24" />
                                    <span class="truncate">{{ $match->equipe1->nom ?? '?' }}</span>
                                </span>
                                <span class="text-lg md:text-xl font-extrabold text-bl-accent mx-2 md:mx-4 flex-shrink-0 font-bundesliga">vs</span>
                                <span class="flex items-center gap-2 font-bold text-white min-w-[80px] md:min-w-[100px] max-w-[120px] md:max-w-[160px] truncate">
                                    <x-team-logo :team="$match->equipe2" :size="24" />
                                    <span class="truncate">{{ $match->equipe2->nom ?? '?' }}</span>
                                </span>
                                <span class="text-xs text-bl-gray ml-2 md:ml-4 flex-shrink-0 text-right w-20 md:w-32 truncate">
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
                        <li class="text-bl-gray italic">Aucun match à venir</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <!-- SECTION APERÇU À PROPOS -->
        <section class="bg-[#23272a] rounded-2xl shadow-lg p-8 mb-10 mt-8 flex flex-col items-center">
            <h2 class="text-2xl md:text-3xl font-extrabold text-bl-accent mb-4 text-center">À propos de l’EUFLU</h2>
            <p class="text-lg text-white mb-4 max-w-2xl text-center">
                L'Entente Urbaine de Football de Lubumbashi (EUFLU) est une organisation sportive basée à Lubumbashi, en République Démocratique du Congo. Affiliée à la FECOFA, elle a pour mission de promouvoir, organiser et encadrer le football urbain, en particulier au niveau amateur et semi-professionnel. L’EUFLU D1, première division de l’entité, développe les jeunes talents, renforce la discipline sportive et valorise le football local à travers des championnats structurés et accessibles.
            </p>
            <p class="text-base text-white mb-6 max-w-2xl text-center">
                Fondée en 1947, l’EUFLU est l’une des plus anciennes structures sportives de Lubumbashi. Depuis 2012, avec la structuration en divisions et groupes, elle a renforcé son rôle dans la gestion des compétitions locales et le développement du football de jeunes talents.
            </p>
            <a href="{{ url('/a-propos') }}" class="inline-block bg-bl-accent hover:bg-[#23272a] text-white hover:text-bl-accent font-bold px-6 py-2 rounded-full shadow transition-all duration-300 border-2 border-bl-accent">En savoir plus</a>
        </section>
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
        // Empêche le scroll manuel tactile (mobile)
        carousel.addEventListener('touchstart', function(e) {
            e.preventDefault();
        }, { passive: false });
        carousel.addEventListener('touchmove', function(e) {
            e.preventDefault();
        }, { passive: false });
        // Empêche le scroll manuel par pointer (drag)
        carousel.addEventListener('pointerdown', function(e) {
            e.preventDefault();
        }, { passive: false });
        carousel.addEventListener('pointermove', function(e) {
            e.preventDefault();
        }, { passive: false });
        // Empêche le scroll clavier (flèches, espace, tab)
        carousel.addEventListener('keydown', function(e) {
            if ([32, 37, 38, 39, 40, 9].includes(e.keyCode)) {
                e.preventDefault();
            }
        });
        carousel.setAttribute('tabindex', '-1'); // Pour éviter le focus clavier
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
    // Défilement automatique pour chaque classement de pool
    document.querySelectorAll('[id^="classement-carousel-"]').forEach(function(carousel) {
        const id = carousel.id.replace('classement-carousel-', '');
        const prevBtn = document.getElementById('classement-prev-' + id);
        const nextBtn = document.getElementById('classement-next-' + id);
        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', function() {
                carousel.scrollBy({ left: -120, behavior: 'smooth' });
            });
            nextBtn.addEventListener('click', function() {
                carousel.scrollBy({ left: 120, behavior: 'smooth' });
            });
        }
        // Auto-scroll horizontal
        let scrollAmount = 2;
        function getMaxScroll() {
            return carousel.scrollWidth - carousel.clientWidth;
        }
        function autoScroll() {
            if (carousel.scrollLeft >= getMaxScroll() - 2) {
                carousel.scrollLeft = 0;
            } else {
                carousel.scrollLeft += scrollAmount;
            }
        }
        let interval = setInterval(autoScroll, 30);
        function startInterval() {
            if (interval) clearInterval(interval);
            interval = setInterval(autoScroll, 30);
        }
        function stopInterval() {
            if (interval) clearInterval(interval);
            interval = null;
        }
        carousel.addEventListener('mouseenter', stopInterval);
        carousel.addEventListener('mouseleave', startInterval);
    });
});
</script>
@endpush
