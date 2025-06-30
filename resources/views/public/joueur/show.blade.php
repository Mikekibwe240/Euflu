@extends('layouts.public')
@section('content')
<div class="container mx-auto p-4">
    <div class="flex flex-col md:flex-row gap-8 items-start">
        <div>
            @if($joueur->photo)
                <span class="inline-flex items-center justify-center h-32 w-32 rounded-full bg-white border border-green-200 dark:border-green-700 overflow-hidden mb-2">
                    <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo du joueur" class="h-32 w-32 object-cover" onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'flex h-32 w-32 rounded-full bg-green-100 text-green-700 font-bold items-center justify-center\'>{{ strtoupper(substr($joueur->nom,0,1)) }}</span>'">
                </span>
            @else
                <span class="flex h-32 w-32 rounded-full bg-green-100 text-green-700 font-bold items-center justify-center">{{ strtoupper(substr($joueur->nom,0,1)) }}</span>
            @endif
            <div class="text-lg font-bold">{{ $joueur->nom }} {{ $joueur->prenom }}</div>
            <div class="text-gray-600">{{ $joueur->poste }}</div>
            <div class="text-gray-600">Équipe : <a href="#" class="text-blue-600 hover:underline">{{ $joueur->equipe->nom ?? '-' }}</a></div>
            <div class="text-gray-600">Saison : {{ $joueur->saison->annee ?? '-' }}</div>
        </div>
        <div class="flex-1">
            <h2 class="text-xl font-semibold mb-2">Statistiques</h2>
            <ul class="mb-4">
                <li>Buts : <span class="font-bold">{{ $stats->buts ?? 0 }}</span></li>
                <li>Cartons jaunes : <span class="font-bold">{{ $stats->cartons_jaunes ?? 0 }}</span></li>
                <li>Cartons rouges : <span class="font-bold">{{ $stats->cartons_rouges ?? 0 }}</span></li>
                <li>MVP (Homme du match) : <span class="font-bold">{{ $stats->mvp ?? 0 }}</span></li>
            </ul>
            <h3 class="font-semibold mb-2">Buts marqués</h3>
            <ul class="mb-4">
                @forelse($buts as $but)
                    <li>
                        {{ $but->rencontre->equipe1->nom }} vs {{ $but->rencontre->equipe2->nom }}
                        @if($but->minute) ({{ $but->minute }}') @endif
                        <a href="{{ route('public.match.show', $but->rencontre) }}" class="text-blue-600 hover:underline">Voir match</a>
                    </li>
                @empty
                    <li class="text-gray-400">Aucun</li>
                @endforelse
            </ul>
            <h3 class="font-semibold mb-2">Cartons reçus</h3>
            <ul class="mb-4">
                @forelse($cartons as $carton)
                    <li>
                        {{ $carton->rencontre->equipe1->nom }} vs {{ $carton->rencontre->equipe2->nom }}
                        - <span class="{{ $carton->type == 'jaune' ? 'text-yellow-600' : 'text-red-600' }}">{{ ucfirst($carton->type) }}</span>
                        @if($carton->minute) ({{ $carton->minute }}') @endif
                        <a href="{{ route('public.match.show', $carton->rencontre) }}" class="text-blue-600 hover:underline">Voir match</a>
                    </li>
                @empty
                    <li class="text-gray-400">Aucun</li>
                @endforelse
            </ul>
            <h3 class="font-semibold mb-2">Historique des clubs</h3>
            @if($joueur->transferts->isEmpty())
                <p class="text-gray-500 italic">Aucun historique de club.</p>
            @else
                <ul class="mb-4 text-sm">
                    @foreach($joueur->transferts->sortByDesc('date') as $transfert)
                        <li>
                            {{ $transfert->date }} :
                            @if($transfert->type === 'transfert')
                                Transfert de <b>{{ $transfert->fromEquipe->nom ?? 'Libre' }}</b> à <b>{{ $transfert->toEquipe->nom ?? 'Libre' }}</b>
                            @elseif($transfert->type === 'affectation')
                                Affectation à <b>{{ $transfert->toEquipe->nom ?? 'Libre' }}</b>
                            @elseif($transfert->type === 'liberation')
                                Libéré de <b>{{ $transfert->fromEquipe->nom ?? 'Libre' }}</b>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
