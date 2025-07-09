@extends('layouts.admin')

@section('title', 'Fiche Joueur')

@section('content')
<div class="container mx-auto py-8">
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif
    <div class="bg-bl-card rounded-lg shadow p-6 mb-8 flex flex-col md:flex-row items-center gap-8 border border-bl-border">
        <div class="flex-shrink-0 flex flex-col items-center">
            @if($joueur->photo)
                <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo {{ $joueur->nom }}" class="h-32 w-32 rounded-full object-cover border-4 border-bl-border bg-bl-card mb-4" onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'h-32 w-32 flex items-center justify-center rounded-full bg-gray-700 mb-4\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#b0b0b0\' viewBox=\'0 0 24 24\' class=\'h-24 w-24\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z\'/></svg></div>'">
            @else
                <div class="h-32 w-32 flex items-center justify-center rounded-full bg-gray-700 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="h-24 w-24">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/>
                    </svg>
                </div>
            @endif
            <div class="text-xl font-semibold text-white">{{ $joueur->nom }} {{ $joueur->prenom }}</div>
            <div class="text-gray-400">Équipe : {{ $joueur->equipe->nom ?? 'Sans équipe' }}</div>
            <div class="text-gray-400">Poste : {{ $joueur->poste ?? '-' }}</div>
            <div class="text-gray-400">Date de naissance : {{ $joueur->date_naissance ?? '-' }}</div>
            <div class="text-gray-400">Numéro de licence : <span class="font-mono">{{ $joueur->numero_licence ?? '-' }}</span></div>
            <div class="text-gray-400">Numéro (dossard) : <span class="font-mono">{{ $joueur->numero_dossard ?? '-' }}</span></div>
            <div class="text-gray-400">Nationalité : {{ $joueur->nationalite ?? '-' }}</div>
        </div>
        <div class="flex-1 w-full">
            <h2 class="text-2xl font-semibold text-white mb-4">Statistiques</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-bl-card border border-bl-border rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-white mb-2">{{ isset($joueur->buts) ? $joueur->buts->count() : 0 }}</div>
                    <div class="text-lg text-white font-semibold">Buts marqués</div>
                </div>
                <div class="bg-bl-card border border-bl-border rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-green-400 mb-2">{{ isset($joueur->buts) ? $joueur->buts->pluck('rencontre_id')->unique()->count() : 0 }}</div>
                    <div class="text-lg text-green-400 font-semibold">Matchs joués</div>
                </div>
                <div class="bg-bl-card border border-bl-border rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-yellow-400 mb-2">
                        @php
                            $ratio = (isset($joueur->buts) && $joueur->buts->pluck('rencontre_id')->unique()->count() > 0)
                                ? round($joueur->buts->count() / $joueur->buts->pluck('rencontre_id')->unique()->count(), 2)
                                : 0;
                        @endphp
                        {{ $ratio }}
                    </div>
                    <div class="text-lg text-yellow-400 font-semibold">Ratio Buts / Match</div>
                </div>
            </div>
            <div class="flex gap-4 mb-6">
                <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 border border-yellow-500 transition">Modifier</a>
                <form action="{{ route('admin.joueurs.destroy', $joueur) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ce joueur ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">Supprimer</button>
                </form>
                <a href="{{ route('admin.joueurs.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow border border-yellow-500 ml-auto transition">← Retour à la liste</a>
            </div>
            <h3 class="font-semibold mb-2 text-white">Historique des clubs</h3>
            @if($joueur->transferts->isEmpty())
                <p class="text-gray-400 italic">Aucun historique de club.</p>
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
