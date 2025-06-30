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
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mb-8 flex flex-col md:flex-row items-center gap-8">
        <div class="flex-shrink-0 flex flex-col items-center">
            @if($joueur->photo)
                <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo {{ $joueur->nom }}" class="h-32 w-32 rounded-full object-cover border-4 border-blue-200 dark:border-blue-700 bg-white mb-4" onerror="this.style.display='none'">
            @else
                <div class="h-32 w-32 flex items-center justify-center rounded-full bg-blue-100 text-blue-700 font-bold text-4xl mb-4">{{ strtoupper(substr($joueur->nom,0,2)) }}</div>
            @endif
            <div class="text-xl font-semibold text-blue-800 dark:text-blue-200">{{ $joueur->nom }} {{ $joueur->prenom }}</div>
            <div class="text-gray-500 dark:text-gray-300">Équipe : {{ $joueur->equipe->nom ?? 'Sans équipe' }}</div>
            <div class="text-gray-500 dark:text-gray-300">Poste : {{ $joueur->poste ?? '-' }}</div>
            <div class="text-gray-500 dark:text-gray-300">Date de naissance : {{ $joueur->date_naissance ?? '-' }}</div>
        </div>
        <div class="flex-1 w-full">
            <h2 class="text-2xl font-semibold text-blue-700 dark:text-blue-300 mb-4">Statistiques</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gradient-to-br from-blue-100 to-blue-300 dark:from-blue-900 dark:to-blue-700 rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-blue-800 dark:text-blue-200 mb-2">{{ isset($joueur->buts) ? $joueur->buts->count() : 0 }}</div>
                    <div class="text-lg text-blue-700 dark:text-blue-300 font-semibold">Buts marqués</div>
                </div>
                <div class="bg-gradient-to-br from-green-100 to-green-300 dark:from-green-900 dark:to-green-700 rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-green-800 dark:text-green-200 mb-2">{{ isset($joueur->buts) ? $joueur->buts->pluck('rencontre_id')->unique()->count() : 0 }}</div>
                    <div class="text-lg text-green-700 dark:text-green-300 font-semibold">Matchs joués</div>
                </div>
                <div class="bg-gradient-to-br from-yellow-100 to-yellow-300 dark:from-yellow-900 dark:to-yellow-700 rounded-xl p-6 flex flex-col items-center shadow">
                    <div class="text-4xl font-bold text-yellow-800 dark:text-yellow-200 mb-2">
                        @php
                            $ratio = (isset($joueur->buts) && $joueur->buts->pluck('rencontre_id')->unique()->count() > 0)
                                ? round($joueur->buts->count() / $joueur->buts->pluck('rencontre_id')->unique()->count(), 2)
                                : 0;
                        @endphp
                        {{ $ratio }}
                    </div>
                    <div class="text-lg text-yellow-700 dark:text-yellow-300 font-semibold">Ratio Buts / Match</div>
                </div>
            </div>
            <div class="flex gap-4 mb-6">
                <a href="{{ route('admin.joueurs.edit', $joueur) }}" class="bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-600 transition">Modifier</a>
                <form action="{{ route('admin.joueurs.destroy', $joueur) }}" method="POST" onsubmit="return confirm('Supprimer ce joueur ? Cette action est irréversible.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition">Supprimer</button>
                </form>
            </div>
            @if(!$joueur->equipe)
            <form action="{{ route('admin.joueurs.affecterEquipe', $joueur) }}" method="POST" class="mb-6 flex flex-col md:flex-row gap-4 items-center bg-blue-50 dark:bg-blue-900 p-4 rounded">
                @csrf
                <label for="equipe_id" class="font-semibold text-blue-800 dark:text-blue-200">Affecter à une équipe :</label>
                <select name="equipe_id" id="equipe_id" class="p-2 border rounded dark:bg-gray-700 dark:text-white" required>
                    <option value="">Sélectionner une équipe</option>
                    @foreach($equipes as $equipe)
                        <option value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">Affecter</button>
            </form>
            @endif
            <div class="flex gap-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary">← Retour</a>
            </div>
            <div class="mt-8">
                <h3 class="text-lg font-bold text-blue-700 dark:text-blue-300 mb-2">Historique des clubs</h3>
                @if($joueur->transferts->isEmpty())
                    <p class="text-gray-500 italic">Aucun historique de club.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($joueur->transferts->sortByDesc('date') as $transfert)
                            <li class="py-2 flex items-center gap-4">
                                <span class="text-gray-700 dark:text-gray-200">
                                    {{ $transfert->date }} :
                                    @if($transfert->type === 'transfert')
                                        Transfert de <b>{{ $transfert->fromEquipe->nom ?? 'Libre' }}</b> à <b>{{ $transfert->toEquipe->nom ?? 'Libre' }}</b>
                                    @elseif($transfert->type === 'affectation')
                                        Affectation à <b>{{ $transfert->toEquipe->nom ?? 'Libre' }}</b>
                                    @elseif($transfert->type === 'liberation')
                                        Libéré de <b>{{ $transfert->fromEquipe->nom ?? 'Libre' }}</b>
                                    @endif
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
