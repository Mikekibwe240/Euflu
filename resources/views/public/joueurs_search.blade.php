@extends('layouts.public')

@section('title', isset($top) && $top === 'buteurs' ? 'Classement des buteurs' : 'Recherche de joueur')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-center text-blue-700 dark:text-blue-300">
        {{ isset($top) && $top === 'buteurs' ? 'Classement des buteurs' : 'Joueurs' }}
    </h1>
    <form method="GET" action="{{ route('public.joueurs.search') }}" class="flex flex-wrap gap-4 justify-center mb-8 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Nom ou prénom..." class="w-56 px-4 py-2 rounded border border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:text-white">
        <select name="equipe_id" class="w-48 px-2 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
            <option value="">Toutes les équipes</option>
            @foreach(\App\Models\Equipe::orderBy('nom')->get() as $equipe)
                <option value="{{ $equipe->id }}" {{ request('equipe_id') == $equipe->id ? 'selected' : '' }}>{{ $equipe->nom }}</option>
            @endforeach
        </select>
        <select name="poste" class="w-40 px-2 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
            <option value="">Tous les postes</option>
            @foreach(\App\Models\Joueur::select('poste')->distinct()->pluck('poste') as $poste)
                <option value="{{ $poste }}" {{ request('poste') == $poste ? 'selected' : '' }}>{{ $poste }}</option>
            @endforeach
        </select>
        @if(isset($top) && $top === 'buteurs')
            <span class="bg-green-100 text-green-700 px-6 py-2 rounded font-semibold ring-2 ring-green-400">Classement buteurs</span>
        @else
            <a href="{{ route('public.joueurs.search', array_merge(request()->except('top'), ['top' => 'buteurs'])) }}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">Classement buteurs</a>
        @endif
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Filtrer</button>
    </form>
    @if(isset($top) && $top === 'buteurs' && isset($pools))
        @foreach($pools as $pool)
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 overflow-x-auto mb-8">
                <h2 class="text-xl font-bold mb-4 text-blue-700 dark:text-blue-300">Classement des buteurs - Pool {{ $pool->nom }}</h2>
                @php $poolJoueurs = $joueurs[$pool->nom] ?? collect(); @endphp
                @if($poolJoueurs->isEmpty())
                    <p class="text-center text-gray-500">Aucun buteur trouvé pour ce pool.</p>
                @else
                <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow table-fixed">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="py-2 px-4 text-center">#</th>
                            <th class="py-2 px-4 text-center">Photo</th>
                            <th class="py-2 px-4 text-center">Nom</th>
                            <th class="py-2 px-4 text-center">Prénom</th>
                            <th class="py-2 px-4 text-center">Poste</th>
                            <th class="py-2 px-4 text-center">Équipe</th>
                            <th class="py-2 px-4 text-center">MJ</th>
                            <th class="py-2 px-4 text-center">Buts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($poolJoueurs as $index => $joueur)
                        <tr class="border-b border-gray-200 dark:border-gray-700 text-center align-middle hover:bg-blue-50 dark:hover:bg-blue-900 transition cursor-pointer" onclick="window.location='{{ route('public.joueurs.show', $joueur->id) }}'">
                            <td class="py-2 px-4 font-semibold text-gray-800 dark:text-gray-100">{{ $index+1 }}</td>
                            <td class="py-2 px-4">
                                @if($joueur->photo)
                                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white border border-gray-200 dark:border-gray-700 overflow-hidden mx-auto">
                                        <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo {{ $joueur->nom }}" class="h-10 w-10 object-cover" onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'flex h-10 w-10 rounded-full bg-green-100 text-green-700 font-bold items-center justify-center\'>{{ strtoupper(substr($joueur->nom,0,1)) }}</span>'">
                                    </span>
                                @else
                                    <span class="flex h-10 w-10 rounded-full bg-green-100 text-green-700 font-bold items-center justify-center">{{ strtoupper(substr($joueur->nom,0,1)) }}</span>
                                @endif
                            </td>
                            <td class="py-2 px-4">{{ $joueur->nom }}</td>
                            <td class="py-2 px-4">{{ $joueur->prenom }}</td>
                            <td class="py-2 px-4">{{ $joueur->poste }}</td>
                            <td class="py-2 px-4">{{ $joueur->equipe->nom ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $joueur->matchs_joues }}</td>
                            <td class="py-2 px-4 font-bold">{{ $joueur->buts_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 text-center">
                    <a href="{{ route('public.joueurs.search', ['top' => 'buteurs', 'pool_id' => $pool->id]) }}" class="inline-block bg-blue-700 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-900 transition">Voir le classement complet</a>
                </div>
                @endif
            </div>
        @endforeach
    @elseif(isset($joueurs))
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 overflow-x-auto">
            @if($joueurs->isEmpty())
                <p class="text-center text-gray-500">Aucun joueur trouvé.</p>
            @else
            <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow table-fixed">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="py-2 px-4 text-center">#</th>
                        <th class="py-2 px-4 text-center">Photo</th>
                        <th class="py-2 px-4 text-center">Nom</th>
                        <th class="py-2 px-4 text-center">Prénom</th>
                        <th class="py-2 px-4 text-center">Poste</th>
                        <th class="py-2 px-4 text-center">Équipe</th>
                        <th class="py-2 px-4 text-center">MJ</th>
                        @if(isset($top) && $top === 'buteurs')
                        <th class="py-2 px-4 text-center">Buts</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($joueurs as $index => $joueur)
                    <tr class="border-b border-gray-200 dark:border-gray-700 text-center align-middle hover:bg-blue-50 dark:hover:bg-blue-900 transition cursor-pointer" onclick="window.location='{{ route('public.joueurs.show', $joueur->id) }}'">
                        <td class="py-2 px-4 font-semibold text-gray-800 dark:text-gray-100">{{ $index+1 }}</td>
                        <td class="py-2 px-4">
                            @if($joueur->photo)
                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white border border-gray-200 dark:border-gray-700 overflow-hidden mx-auto">
                                    <img src="{{ asset('storage/' . $joueur->photo) }}" alt="Photo {{ $joueur->nom }}" class="h-10 w-10 object-cover" onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'flex h-10 w-10 rounded-full bg-green-100 text-green-700 font-bold items-center justify-center\'>{{ strtoupper(substr($joueur->nom,0,1)) }}</span>'">
                                </span>
                            @else
                                <span class="flex h-10 w-10 rounded-full bg-green-100 text-green-700 font-bold items-center justify-center">{{ strtoupper(substr($joueur->nom,0,1)) }}</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 text-gray-800 dark:text-gray-100">
                            <a href="{{ route('public.joueurs.show', $joueur->id) }}" class="block w-full h-full focus:outline-none focus:ring-2 focus:ring-blue-500 rounded transition-colors duration-200">
                                {{ $joueur->nom }}
                            </a>
                        </td>
                        <td class="py-2 px-4 text-gray-800 dark:text-gray-100">{{ $joueur->prenom }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200">{{ $joueur->poste }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200">{{ $joueur->equipe->nom ?? '-' }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-200">{{ $joueur->matchs_joues ?? 0 }}</td>
                        @if(isset($top) && $top === 'buteurs')
                        <td class="py-2 px-4 text-blue-700 dark:text-blue-300 font-bold text-lg">{{ $joueur->buts_count ?? 0 }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    @endif
</div>
@endsection
