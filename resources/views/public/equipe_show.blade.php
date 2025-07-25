@extends('layouts.public')

@section('title', 'Détail de l\'équipe')

@section('content')
<div class="w-full bg-[#e2001a] py-10 px-4 flex flex-col items-center relative mb-8">
    <div class="text-3xl md:text-4xl font-extrabold text-white uppercase tracking-wider mb-2">{{ $equipe->nom }}</div>
    <div class="text-base text-white font-semibold uppercase mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.382V5a2 2 0 012-2h14a2 2 0 012 2v10.382a2 2 0 01-1.553 1.894L15 20" /></svg>
        {{ $equipe->stade ?? 'Stade inconnu' }}
    </div>
    <div class="absolute right-8 top-8">
        <x-team-logo :team="$equipe" :size="120" />
    </div>
</div>
<div class="max-w-6xl mx-auto px-4">
    <div class="flex flex-col md:flex-row gap-8 mb-8">
        <div class="flex-1">
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="bg-[#23272a] rounded-lg shadow p-6 flex-1 flex flex-col items-center">
                    <div class="text-2xl font-bold text-white mb-2">{{ $stats->points ?? 0 }}</div>
                    <div class="text-gray-400">Points</div>
                </div>
                <div class="bg-[#23272a] rounded-lg shadow p-6 flex-1 flex flex-col items-center">
                    <div class="text-2xl font-bold text-white mb-2">{{ $stats->victoires ?? 0 }}</div>
                    <div class="text-gray-400">Victoires</div>
                </div>
                <div class="bg-[#23272a] rounded-lg shadow p-6 flex-1 flex flex-col items-center">
                    <div class="text-2xl font-bold text-white mb-2">{{ $stats->nuls ?? 0 }}</div>
                    <div class="text-gray-400">Nuls</div>
                </div>
                <div class="bg-[#23272a] rounded-lg shadow p-6 flex-1 flex flex-col items-center">
                    <div class="text-2xl font-bold text-white mb-2">{{ $stats->defaites ?? 0 }}</div>
                    <div class="text-gray-400">Défaites</div>
                </div>
            </div>
            <div class="bg-[#23272a] rounded-lg shadow p-6 mb-6">
                <div class="flex items-center gap-4 mb-2">
                    <span class="text-lg font-bold text-white">Pool :</span>
                    <span class="text-[#6fcf97] font-extrabold uppercase">{{ $equipe->pool->nom ?? '-' }}</span>
                </div>
                <div class="flex items-center gap-4 mb-2">
                    <span class="text-lg font-bold text-white">Coach :</span>
                    <span class="text-white">{{ $equipe->coach ?? '-' }}</span>
                </div>
                <div class="flex items-center gap-4 mb-2">
                    <span class="text-lg font-bold text-white">Saison :</span>
                    <span class="text-white">{{ $equipe->saison->nom ?? '-' }}</span>
                </div>
                <div class="flex items-center gap-4 mb-2">
                    <span class="text-lg font-bold text-white">Classement :</span>
                    <span class="text-white">{{ $position ?? '-' }}</span>
                </div>
            </div>
        </div>
        <div class="flex-1 flex flex-col items-center">
            <div class="bg-[#23272a] rounded-lg shadow p-6 w-full flex flex-col items-center mb-6">
                <div class="text-lg font-bold text-white mb-2">Meilleur buteur</div>
                @php
                    $meilleur = $equipe->joueurs->sortByDesc(fn($j) => $j->buts->count())->first();
                @endphp
                @if($meilleur)
                    <div class="flex items-center gap-3">
                        @if($meilleur->photo)
                            <img src="{{ asset('storage/' . $meilleur->photo) }}" alt="Photo {{ $meilleur->nom }}" class="h-12 w-12 rounded-full object-cover border border-gray-200 bg-white">
                        @else
                            <div class="h-12 w-12 rounded-full bg-gray-700 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-10 w-10">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                                </svg>
                            </div>
                        @endif
                        <span class="font-semibold text-white text-lg">{{ $meilleur->nom }} {{ $meilleur->prenom }}</span>
                        <span class="text-[#6fcf97] font-bold text-lg">{{ $meilleur->buts->count() }} buts</span>
                    </div>
                @else
                    <span class="text-gray-400">Aucun buteur</span>
                @endif
            </div>
            <div class="bg-[#23272a] rounded-lg shadow p-6 w-full flex flex-col items-center">
                <div class="text-lg font-bold text-white mb-2">Nombre de joueurs</div>
                <span class="text-3xl font-extrabold text-[#6fcf97]">{{ $equipe->joueurs->count() }}</span>
            </div>
        </div>
    </div>
    <div class="mb-8">
        <div class="text-2xl font-bold text-white mb-4">Joueurs de l'équipe</div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($equipe->joueurs as $joueur)
                <a href="{{ route('public.joueurs.show', $joueur->id) }}" class="flex items-center gap-4 bg-[#181d1f] rounded-lg p-4 hover:bg-[#23272a] transition group border border-[#31363a]">
                    @if($joueur->photo)
                        <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo {{ $joueur->nom }}" class="h-12 w-12 rounded-full object-cover border border-gray-200 bg-white">
                    @else
                        <div class="h-12 w-12 rounded-full bg-gray-700 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-10 w-10">
                                <circle cx="12" cy="8" r="4"/>
                                <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <div class="font-bold text-white text-lg group-hover:text-[#6fcf97]">{{ $joueur->nom }} {{ $joueur->prenom }}</div>
                        <div class="text-gray-400 text-sm">{{ $joueur->poste }}</div>
                        <div class="text-xs text-gray-300 mt-1 flex flex-wrap gap-2">
                            <span><strong>Nationalité :</strong> {{ $joueur->nationalite ?? '-' }}</span>
                            <span><strong>Licence :</strong> {{ $joueur->numero_licence ?? '-' }}</span>
                            <span><strong>Dossard :</strong> {{ $joueur->numero_dossard ?? '-' }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="mb-8">
        <div class="text-2xl font-bold text-white mb-4">Rencontres</div>
        <div class="overflow-x-auto rounded-lg shadow" style="background:#181d1f;">
            <table class="min-w-full bg-[#23272a] text-white text-base bundesliga-table" style="border-radius:0;">
                <thead class="bg-transparent text-white uppercase text-base">
                    <tr>
                        <th class="px-4 py-3 text-left font-extrabold">Date</th>
                        <th class="px-4 py-3 text-left font-extrabold">Adversaire</th>
                        <th class="px-4 py-3 text-center font-extrabold">Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rencontres as $match)
                        <tr>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($match->date)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 flex items-center gap-2">
                                @php
                                    $adversaire = $match->equipe1_id == $equipe->id ? $match->equipe2 : $match->equipe1;
                                @endphp
                                <x-team-logo :team="$adversaire" :size="32" />
                                {{ $adversaire->nom ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($match->score_equipe1 !== null && $match->score_equipe2 !== null)
                                    {{ $match->equipe1_id == $equipe->id ? $match->score_equipe1 : $match->score_equipe2 }} - {{ $match->equipe1_id == $equipe->id ? $match->score_equipe2 : $match->score_equipe1 }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mb-8">
        <div class="text-2xl font-bold text-white mb-4">Progression (points cumulés)</div>
        <canvas id="progressionChart" height="120"></canvas>
        <div class="mt-2 text-sm text-gray-400">Points cumulés : <span class="font-bold" id="points-cumules"></span></div>
    </div>
    <div class="mt-4 text-center">
        <a href="{{ route('public.equipes') }}" class="inline-block bg-[#23272a] text-white font-bold px-6 py-2 rounded-full shadow hover:bg-[#6fcf97] hover:text-[#23272a] transition-all duration-300 font-inter">← Retour aux clubs</a>
    </div>
</div>
@endsection

@push('scripts')
<script src="/js/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
// Carrousel auto-défilant moderne (images + vidéo)
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
@if(!empty($rencontres) && !$rencontres->isEmpty())
    const rencontres = @json($rencontres);
    const equipeId = @json($equipe->id);
    let labels = [];
    let points = [];
    let total = 0;
    rencontres.forEach(match => {
        let isHome = match.equipe1_id == equipeId;
        let score1 = match.score_equipe1;
        let score2 = match.score_equipe2;
        let label = match.date + ' vs ' + (isHome ? (match.equipe2?.nom || '-') : (match.equipe1?.nom || '-'));
        labels.push(label);
        if(score1 !== null && score2 !== null) {
            if((isHome && score1 > score2) || (!isHome && score2 > score1)) total += 3;
            else if(score1 == score2) total += 1;
        }
        points.push(total);
    });
    document.getElementById('points-cumules').textContent = total;
    new Chart(document.getElementById('progressionChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Points cumulés',
                data: points,
                fill: true,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,0.1)',
                tension: 0.3,
                pointBackgroundColor: '#2563eb',
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                x: { title: { display: true, text: 'Match' } },
                y: { title: { display: true, text: 'Points cumulés' }, beginAtZero: true, precision:0 }
            }
        }
    });
@else
    // Affiche un graphique vide pour garder l'harmonie visuelle
    new Chart(document.getElementById('progressionChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Aucune donnée'],
            datasets: [{
                label: 'Points cumulés',
                data: [0],
                fill: true,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,0.1)',
                tension: 0.3,
                pointBackgroundColor: '#2563eb',
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: false }
            },
            scales: {
                x: { title: { display: true, text: 'Match' } },
                y: { title: { display: true, text: 'Points cumulés' }, beginAtZero: true, precision:0 }
            }
        }
    });
@endif
});
</script>
@endpush
