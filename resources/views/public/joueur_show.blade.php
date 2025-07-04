@extends('layouts.public')

@section('title', 'Détail du joueur')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-[#181d1f] rounded-lg shadow p-6 mb-8 flex flex-col md:flex-row items-center gap-8 border border-[#23272a]">
        <div class="flex-shrink-0 flex flex-col items-center">
            @if($joueur->photo)
                <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo {{ $joueur->nom }}" class="h-36 w-36 rounded-full object-cover border-4 border-[#e2001a] shadow mb-4">
            @else
                <div class="h-36 w-36 flex items-center justify-center rounded-full bg-gray-700 mb-4 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-24 w-24">
                        <circle cx="12" cy="8" r="8"/>
                        <path d="M4 20c0-5 4.134-9 8-9s8 4 8 9v1H4v-1z"/>
                    </svg>
                </div>
            @endif
            <div class="text-3xl font-extrabold text-white mb-2 uppercase tracking-wider">{{ $joueur->nom }} <span class="font-light">{{ $joueur->prenom }}</span></div>
            <div class="flex items-center gap-2 text-gray-300 mb-1">
                @if($joueur->equipe)
                    <x-team-logo :team="$joueur->equipe" :size="28" />
                @endif
                <span class="font-semibold">{{ $joueur->equipe->nom ?? 'Sans équipe' }}</span>
            </div>
            <div class="text-gray-400 mb-1">Poste : <span class="font-semibold text-white">{{ $joueur->poste ?? '-' }}</span></div>
            <div class="text-gray-400 mb-1">Date de naissance : <span class="font-semibold text-white">{{ $joueur->date_naissance ?? '-' }}</span></div>
            @if($joueur->equipe)
                <a href="{{ url('/equipes/'.$joueur->equipe->id) }}" class="mt-2 inline-block bg-[#e2001a] text-white px-4 py-1 rounded-full text-xs font-bold shadow hover:bg-[#b80015] transition">Voir l'équipe</a>
            @endif
        </div>
        <div class="flex-1 w-full">
            <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-2">
                <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-[#e2001a]' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M13 16h-1v-4h-1m4 4h-1v-4h-1m-4 4h-1v-4h-1m4 4h-1v-4h-1'/>
                </svg>
                Statistiques
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-[#23272a] rounded-xl p-6 flex flex-col items-center shadow border border-[#23272a]">
                    <div class="text-4xl font-bold text-[#e2001a] mb-2 flex items-center gap-2">
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-7 w-7' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 6v6l4 2'/>
                        </svg>
                        {{ isset($joueur->buts) ? $joueur->buts->count() : 0 }}
                    </div>
                    <div class="text-lg text-white font-semibold">Buts marqués</div>
                </div>
                <div class="bg-[#23272a] rounded-xl p-6 flex flex-col items-center shadow border border-[#23272a]">
                    <div class="text-4xl font-bold text-blue-400 mb-2 flex items-center gap-2">
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-7 w-7' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'/>
                        </svg>
                        {{ isset($joueur->buts) ? $joueur->buts->pluck('rencontre_id')->unique()->count() : 0 }}
                    </div>
                    <div class="text-lg text-white font-semibold">Matchs joués</div>
                </div>
                <div class="bg-[#23272a] rounded-xl p-6 flex flex-col items-center shadow border border-[#23272a]">
                    <div class="text-4xl font-bold text-yellow-400 mb-2 flex items-center gap-2">
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-7 w-7' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z'/>
                        </svg>
                        @php
                            $ratio = (isset($joueur->buts) && $joueur->buts->pluck('rencontre_id')->unique()->count() > 0)
                                ? round($joueur->buts->count() / $joueur->buts->pluck('rencontre_id')->unique()->count(), 2)
                                : 0;
                        @endphp
                        {{ $ratio }}
                    </div>
                    <div class="text-lg text-white font-semibold">Ratio Buts / Match</div>
                </div>
            </div>
            <div class="bg-[#23272a] rounded-lg p-4 mt-4 border border-[#23272a]">
                <h3 class="text-lg font-bold text-white mb-2">Informations</h3>
                <ul class="text-gray-300 text-sm space-y-1">
                    <li><span class="font-semibold text-white">Nom complet :</span> {{ $joueur->nom }} {{ $joueur->prenom }}</li>
                    <li><span class="font-semibold text-white">Poste :</span> {{ $joueur->poste ?? '-' }}</li>
                    <li><span class="font-semibold text-white">Date de naissance :</span> {{ $joueur->date_naissance ?? '-' }}</li>
                    <li><span class="font-semibold text-white">Équipe :</span> {{ $joueur->equipe->nom ?? 'Sans équipe' }}</li>
                    <li><span class="font-semibold text-white">Numéro de licence :</span> <span class="font-mono">{{ $joueur->numero_licence ?? '-' }}</span></li>
                    <li><span class="font-semibold text-white">Numéro (dossard) :</span> <span class="font-mono">{{ $joueur->numero_dossard ?? '-' }}</span></li>
                    <li><span class="font-semibold text-white">Nationalité :</span> {{ $joueur->nationalite ?? '-' }}</li>
                </ul>
            </div>
            <div class="bg-[#23272a] rounded-lg p-4 mt-8 border border-[#23272a]">
                <h3 class="text-lg font-bold text-white mb-2">Historique des clubs</h3>
                @if($joueur->transferts->isEmpty())
                    <p class="text-gray-400 italic">Ce joueur n’a pas encore changé de club ou n’a pas d’historique de transfert.</p>
                @else
                    <ul class="divide-y divide-gray-700">
                        @foreach($joueur->transferts->sortByDesc('date') as $transfert)
                            <li class="py-2 flex items-center gap-4">
                                <span class="text-gray-200">
                                    @php
                                        $date = $transfert->date ? \Carbon\Carbon::parse($transfert->date)->format('d/m/Y') : '';
                                        $from = $transfert->fromEquipe->nom ?? 'Libre';
                                        $to = $transfert->toEquipe->nom ?? 'Libre';
                                    @endphp
                                    @if($transfert->type === 'transfert')
                                        Le {{ $date }} : Transféré de <b>{{ $from }}</b> à <b>{{ $to }}</b>
                                    @elseif($transfert->type === 'affectation')
                                        Le {{ $date }} : Affecté à <b>{{ $to }}</b>
                                    @elseif($transfert->type === 'liberation')
                                        Le {{ $date }} : Libéré de <b>{{ $from }}</b>
                                    @else
                                        Le {{ $date }} : Mouvement de club
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <div class="flex justify-between">
        <a href="{{ url()->previous() }}" class="inline-block bg-[#23272a] text-white font-bold px-6 py-2 rounded-full shadow hover:bg-[#e2001a] transition-all duration-300 font-inter">← Retour</a>
    </div>
</div>
@endsection
