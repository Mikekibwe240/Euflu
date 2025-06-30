@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4 max-w-4xl">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
            <div class="flex items-center gap-4">
                <div class="flex flex-col items-center">
                    @if($rencontre->equipe1)
                        <x-team-logo :team="$rencontre->equipe1" size="64" />
                    @elseif($rencontre->equipe1_libre)
                        <x-team-logo :team="(object)['nom'=>$rencontre->equipe1_libre]" size="64" />
                    @else
                        <x-team-logo :team="null" size="64" />
                    @endif
                    @if($rencontre->equipe1 || $rencontre->equipe1_libre)
                        <span class="mt-2 font-semibold text-blue-800 dark:text-blue-200">{{ $rencontre->equipe1->nom ?? $rencontre->equipe1_libre }}</span>
                    @else
                        <span class="mt-2 text-gray-400">Non renseigné</span>
                    @endif
                </div>
                <div class="flex flex-col items-center mx-4">
                    <span class="text-3xl font-extrabold text-gray-800 dark:text-white bg-blue-100 dark:bg-blue-900 px-4 py-2 rounded-lg shadow">{{ $rencontre->score_equipe1 ?? '-' }} <span class="text-lg">-</span> {{ $rencontre->score_equipe2 ?? '-' }}</span>
                    <span class="text-xs text-gray-500 mt-1">{{ $rencontre->type_rencontre ? ucfirst($rencontre->type_rencontre) : '' }}</span>
                </div>
                <div class="flex flex-col items-center">
                    @if($rencontre->equipe2)
                        <x-team-logo :team="$rencontre->equipe2" size="64" />
                    @elseif($rencontre->equipe2_libre)
                        <x-team-logo :team="(object)['nom'=>$rencontre->equipe2_libre]" size="64" />
                    @else
                        <x-team-logo :team="null" size="64" />
                    @endif
                    @if($rencontre->equipe2 || $rencontre->equipe2_libre)
                        <span class="mt-2 font-semibold text-blue-800 dark:text-blue-200">{{ $rencontre->equipe2->nom ?? $rencontre->equipe2_libre }}</span>
                    @else
                        <span class="mt-2 text-gray-400">Non renseigné</span>
                    @endif
                </div>
            </div>
            <div class="text-right">
                <div class="text-gray-600 dark:text-gray-300 mb-1">{{ $rencontre->date }} à {{ $rencontre->heure }}</div>
                <div class="text-gray-600 dark:text-gray-300 mb-1">Stade : {{ $rencontre->stade }}</div>
                @if($rencontre->pool)
                    <div class="text-gray-500 text-sm">Poule : {{ $rencontre->pool->nom }}</div>
                @endif
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-center mb-4">
            <div class="bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 rounded-lg px-4 py-2 text-center">
                <div class="font-bold text-lg">Homme du match</div>
                <div>
                    @if($rencontre->mvp)
                        {{ $rencontre->mvp->nom }} {{ $rencontre->mvp->prenom }}
                        <span class="text-xs">
                            (
                            {{ $rencontre->mvp->equipe->nom ?? $rencontre->mvp->equipe_libre_nom ?? 'Équipe inconnue' }}
                            )
                        </span>
                    @else
                        <span class="text-gray-400">Non renseigné</span>
                    @endif
                </div>
            </div>
            <div class="bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 rounded-lg px-4 py-2 text-center">
                <div class="font-bold text-lg">Buts</div>
                <div>{{ $rencontre->buts->count() }}</div>
            </div>
            <div class="bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-200 rounded-lg px-4 py-2 text-center">
                <div class="font-bold text-lg">Cartons</div>
                <div>{{ $rencontre->cartons->count() }}</div>
            </div>
        </div>
        <div class="flex flex-wrap gap-2 justify-center mb-4">
            <a href="{{ route('admin.rencontres.edit', $rencontre) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Modifier</a>
            <a href="{{ route('admin.rencontres.editResultat', $rencontre) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Saisir/Modifier résultat</a>
            <form action="{{ route('admin.rencontres.resetResultat', $rencontre) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer tous les résultats de cette rencontre ?');">
                @csrf
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">Supprimer les résultats</button>
            </form>
            <form action="{{ route('admin.rencontres.destroy', $rencontre) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette rencontre ? Cette action est irréversible.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Supprimer</button>
            </form>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <h3 class="font-semibold mb-2 text-blue-700 dark:text-blue-300">Buteurs {{ $rencontre->equipe1?->nom ?? $rencontre->equipe1_libre ?? '-' }}</h3>
            <ul>
                @php
                    $buts1 = $rencontre->buts->filter(function($but) use ($rencontre) {
                        if ($rencontre->equipe1) {
                            return $but->equipe_id == $rencontre->equipe1->id;
                        } elseif ($rencontre->equipe1_libre) {
                            return is_null($but->equipe_id) && ($but->equipe_libre_nom ?? null) == $rencontre->equipe1_libre;
                        }
                        return false;
                    });
                @endphp
                @foreach($buts1 as $but)
                    <li>
                        @if($but->joueur)
                            {{ $but->joueur->nom }} {{ $but->joueur->prenom }}
                            @if($but->minute) ({{ $but->minute }}') @endif
                        @endif
                    </li>
                @endforeach
                @if($buts1->isEmpty())
                    <li class="text-gray-400">Aucun</li>
                @endif
            </ul>
        </div>
        <div>
            <h3 class="font-semibold mb-2 text-blue-700 dark:text-blue-300">Buteurs {{ $rencontre->equipe2?->nom ?? $rencontre->equipe2_libre ?? '-' }}</h3>
            <ul>
                @php
                    $buts2 = $rencontre->buts->filter(function($but) use ($rencontre) {
                        if ($rencontre->equipe2) {
                            return $but->equipe_id == $rencontre->equipe2->id;
                        } elseif ($rencontre->equipe2_libre) {
                            return is_null($but->equipe_id) && ($but->equipe_libre_nom ?? null) == $rencontre->equipe2_libre;
                        }
                        return false;
                    });
                @endphp
                @foreach($buts2 as $but)
                    <li>
                        @if($but->joueur)
                            {{ $but->joueur->nom }} {{ $but->joueur->prenom }}
                            @if($but->minute) ({{ $but->minute }}') @endif
                        @endif
                    </li>
                @endforeach
                @if($buts2->isEmpty())
                    <li class="text-gray-400">Aucun</li>
                @endif
            </ul>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <h3 class="font-semibold mb-2 text-yellow-700 dark:text-yellow-300">Cartons {{ $rencontre->equipe1?->nom ?? $rencontre->equipe1_libre ?? '-' }}</h3>
            <ul>
                @php
                    $cartons1 = $rencontre->cartons->filter(function($carton) use ($rencontre) {
                        if ($rencontre->equipe1) {
                            return $carton->equipe_id == $rencontre->equipe1->id;
                        } elseif ($rencontre->equipe1_libre) {
                            return is_null($carton->equipe_id) && ($carton->equipe_libre_nom ?? null) == $rencontre->equipe1_libre;
                        }
                        return false;
                    });
                @endphp
                @foreach($cartons1 as $carton)
                    <li>
                        @if($carton->joueur)
                            {{ $carton->joueur->nom }} {{ $carton->joueur->prenom }}
                            - <span class="{{ $carton->type == 'jaune' ? 'text-yellow-600' : 'text-red-600' }}">{{ ucfirst($carton->type) }}</span>
                            @if($carton->minute) ({{ $carton->minute }}') @endif
                        @endif
                    </li>
                @endforeach
                @if($cartons1->isEmpty())
                    <li class="text-gray-400">Aucun</li>
                @endif
            </ul>
        </div>
        <div>
            <h3 class="font-semibold mb-2 text-yellow-700 dark:text-yellow-300">Cartons {{ $rencontre->equipe2?->nom ?? $rencontre->equipe2_libre ?? '-' }}</h3>
            <ul>
                @php
                    $cartons2 = $rencontre->cartons->filter(function($carton) use ($rencontre) {
                        if ($rencontre->equipe2) {
                            return $carton->equipe_id == $rencontre->equipe2->id;
                        } elseif ($rencontre->equipe2_libre) {
                            return is_null($carton->equipe_id) && ($carton->equipe_libre_nom ?? null) == $rencontre->equipe2_libre;
                        }
                        return false;
                    });
                @endphp
                @foreach($cartons2 as $carton)
                    <li>
                        @if($carton->joueur)
                            {{ $carton->joueur->nom }} {{ $carton->joueur->prenom }}
                            - <span class="{{ $carton->type == 'jaune' ? 'text-yellow-600' : 'text-red-600' }}">{{ ucfirst($carton->type) }}</span>
                            @if($carton->minute) ({{ $carton->minute }}') @endif
                        @endif
                    </li>
                @endforeach
                @if($cartons2->isEmpty())
                    <li class="text-gray-400">Aucun</li>
                @endif
            </ul>
        </div>
    </div>
    <div class="mb-6">
        <h3 class="font-semibold mb-2 text-gray-700 dark:text-gray-200">Effectifs</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <strong>{{ $rencontre->equipe1?->nom ?? $rencontre->equipe1_libre ?? '-' }}</strong>
                <ul>
                    @if($rencontre->equipe1)
                        @foreach($rencontre->equipe1->joueurs as $joueur)
                            <li>{{ $joueur->nom }} {{ $joueur->prenom }}</li>
                        @endforeach
                    @elseif($rencontre->equipe1_libre)
                        <li class="text-gray-400">Cette équipe n'est pas enregistrée dans le championnat.</li>
                    @else
                        <li class="text-gray-400">Aucune équipe</li>
                    @endif
                </ul>
            </div>
            <div>
                <strong>{{ $rencontre->equipe2?->nom ?? $rencontre->equipe2_libre ?? '-' }}</strong>
                <ul>
                    @if($rencontre->equipe2)
                        @foreach($rencontre->equipe2->joueurs as $joueur)
                            <li>{{ $joueur->nom }} {{ $joueur->prenom }}</li>
                        @endforeach
                    @elseif($rencontre->equipe2_libre)
                        <li class="text-gray-400">Cette équipe n'est pas enregistrée dans le championnat.</li>
                    @else
                        <li class="text-gray-400">Aucune équipe</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
