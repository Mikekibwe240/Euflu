@extends('layouts.admin')
@section('content')
<div class="max-w-4xl mx-auto bg-bl-card border border-bl-border rounded-xl shadow-lg p-8 mt-8">
    <h2 class="text-2xl font-extrabold mb-6 text-white tracking-wide">Saisir / Modifier le résultat</h2>
    @if($errors->any())
        <div class="bg-red-900/80 text-white border border-red-700 p-3 mb-6 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.rencontres.updateResultat', $rencontre) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        <div class="flex flex-wrap gap-4 items-center justify-between">
            <span class="font-semibold text-white min-w-[100px] truncate">
                @if($rencontre->equipe1_libre)
                    <span class="italic text-gray-400">{{ $rencontre->equipe1_libre }}</span>
                @elseif($rencontre->equipe1)
                    {{ $rencontre->equipe1->nom }}
                @else
                    -
                @endif
            </span>
            <input type="number" name="score_equipe1" value="{{ old('score_equipe1', $rencontre->score_equipe1) }}" class="form-input w-20 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition text-center" min="0" required>
            <span class="mx-2 text-white text-xl font-bold">-</span>
            <input type="number" name="score_equipe2" value="{{ old('score_equipe2', $rencontre->score_equipe2) }}" class="form-input w-20 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition text-center" min="0" required>
            <span class="font-semibold text-white min-w-[100px] truncate">
                @if($rencontre->equipe2_libre)
                    <span class="italic text-gray-400">{{ $rencontre->equipe2_libre }}</span>
                @elseif($rencontre->equipe2)
                    {{ $rencontre->equipe2->nom }}
                @else
                    -
                @endif
            </span>
        </div>
        <div class="text-xs text-gray-400 mb-2">
            <span>Le score doit être justifié par le même nombre de buteurs saisis pour chaque équipe.</span>
        </div>
        <hr class="border-bl-border">
        <h3 class="text-lg font-semibold mt-4 mb-2 text-white">Buteurs</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-semibold mb-2 text-white truncate">{{ $rencontre->equipe1->nom ?? '-' }}</h4>
                <div id="buteurs-equipe1-list">
                    @php
                        $nb = old('score_equipe1', $rencontre->score_equipe1 ?? 0);
                        $buts = $rencontre->buts->where('equipe_id', $rencontre->equipe1->id ?? null)->values();
                    @endphp
                    @php
                        $oldButeurs = old('buteurs_equipe1', []);
                        $nb = max(count($oldButeurs), $buts->count(), old('score_equipe1', $rencontre->score_equipe1 ?? 0));
                    @endphp
                    @for($i = 0; $i < $nb; $i++)
                        <div class="flex flex-wrap gap-2 mb-2 buteur-row items-center">
                            <select name="buteurs_equipe1[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition w-40">
                                <option value="">Sélectionner un joueur</option>
                                @foreach($joueursEquipe1 as $joueur)
                                    <option value="{{ $joueur->id }}" @if(old('buteurs_equipe1.'.$i, $buts[$i]->joueur_id ?? null) == $joueur->id) selected @endif>{{ $joueur->nom }} {{ $joueur->prenom }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="minutes_buteurs_equipe1[]" class="form-input w-24 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" placeholder="Minute" value="{{ old('minutes_buteurs_equipe1.'.$i, $buts[$i]->minute ?? '') }}">
                        </div>
                    @endfor
                </div>
                <button type="button" id="add-buteur-equipe1" class="bg-green-700 text-white px-2 py-1 rounded mt-2">+ Ajouter buteur</button>
            </div>
            <div>
                <h4 class="font-semibold mb-2 text-white truncate">{{ $rencontre->equipe2->nom ?? '-' }}</h4>
                <div id="buteurs-equipe2-list">
                    @php
                        $nb = old('score_equipe2', $rencontre->score_equipe2 ?? 0);
                        $buts = $rencontre->buts->where('equipe_id', $rencontre->equipe2->id ?? null)->values();
                    @endphp
                    @php
                        $oldButeurs = old('buteurs_equipe2', []);
                        $nb = max(count($oldButeurs), $buts->count(), old('score_equipe2', $rencontre->score_equipe2 ?? 0));
                    @endphp
                    @for($i = 0; $i < $nb; $i++)
                        <div class="flex flex-wrap gap-2 mb-2 buteur-row items-center">
                            <select name="buteurs_equipe2[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus-border-bl-accent transition w-40">
                                <option value="">Sélectionner un joueur</option>
                                @foreach($joueursEquipe2 as $joueur)
                                    <option value="{{ $joueur->id }}" @if(old('buteurs_equipe2.'.$i, $buts[$i]->joueur_id ?? null) == $joueur->id) selected @endif>{{ $joueur->nom }} {{ $joueur->prenom }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="minutes_buteurs_equipe2[]" class="form-input w-24 bg-bl-dark text-white border-bl-border focus:ring-2 focus-ring-bl-accent focus-border-bl-accent transition" placeholder="Minute" value="{{ old('minutes_buteurs_equipe2.'.$i, $buts[$i]->minute ?? '') }}">
                        </div>
                    @endfor
                </div>
                <button type="button" id="add-buteur-equipe2" class="bg-green-700 text-white px-2 py-1 rounded mt-2">+ Ajouter buteur</button>
            </div>
        </div>
        <hr class="border-bl-border">
        <h3 class="text-lg font-semibold mt-4 mb-2 text-white">Cartons</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-semibold mb-2 text-white truncate">
                    {{ $rencontre->equipe1->nom ?? '-' }}
                </h4>
                <div id="cartons-equipe1-list">
                    @php
                        $cartons = $rencontre->cartons->where('equipe_id', $rencontre->equipe1->id ?? null)->values();
                        $oldCartons = old('cartons_equipe1', []);
                        $nb = max(count($oldCartons), $cartons->count(), 1);
                    @endphp
                    @for($i = 0; $i < $nb; $i++)
                        <div class="flex flex-wrap gap-2 mb-2 carton-row items-center">
                            <select name="cartons_equipe1[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus-border-bl-accent transition w-40">
                                <option value="">Sélectionner un joueur</option>
                                @foreach($joueursEquipe1 as $joueur)
                                    <option value="{{ $joueur->id }}" @if(old('cartons_equipe1.'.$i, $cartons[$i]->joueur_id ?? null) == $joueur->id) selected @endif>{{ $joueur->nom }} {{ $joueur->prenom }}</option>
                                @endforeach
                            </select>
                            <select name="type_cartons_equipe1[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus-border-bl-accent transition w-24">
                                <option value="jaune" @if(old('type_cartons_equipe1.'.$i, $cartons[$i]->type ?? null)=='jaune') selected @endif>Jaune</option>
                                <option value="rouge" @if(old('type_cartons_equipe1.'.$i, $cartons[$i]->type ?? null)=='rouge') selected @endif>Rouge</option>
                            </select>
                            <input type="number" name="minutes_cartons_equipe1[]" class="form-input w-20 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus-border-bl-accent transition" placeholder="Minute" value="{{ old('minutes_cartons_equipe1.'.$i, $cartons[$i]->minute ?? null) }}">
                            <button type="button" class="remove-carton bg-red-500 text-white px-2 rounded">X</button>
                        </div>
                    @endfor
                </div>
                <button type="button" id="add-carton-equipe1" class="bg-yellow-600 text-white px-2 py-1 rounded mt-2">+ Ajouter carton</button>
            </div>
            <div>
                <h4 class="font-semibold mb-2 text-white truncate">
                    {{ $rencontre->equipe2->nom ?? '-' }}
                </h4>
                <div id="cartons-equipe2-list">
                    @php
                        $cartons = $rencontre->cartons->where('equipe_id', $rencontre->equipe2->id ?? null)->values();
                        $oldCartons = old('cartons_equipe2', []);
                        $nb = max(count($oldCartons), $cartons->count(), 1);
                    @endphp
                    @for($i = 0; $i < $nb; $i++)
                        <div class="flex flex-wrap gap-2 mb-2 carton-row items-center">
                            <select name="cartons_equipe2[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus-border-bl-accent transition w-40">
                                <option value="">Sélectionner un joueur</option>
                                @foreach($joueursEquipe2 as $joueur)
                                    <option value="{{ $joueur->id }}" @if(old('cartons_equipe2.'.$i, $cartons[$i]->joueur_id ?? null) == $joueur->id) selected @endif>{{ $joueur->nom }} {{ $joueur->prenom }}</option>
                                @endforeach
                            </select>
                            <select name="type_cartons_equipe2[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus-border-bl-accent transition w-24">
                                <option value="jaune" @if(old('type_cartons_equipe2.'.$i, $cartons[$i]->type ?? null)=='jaune') selected @endif>Jaune</option>
                                <option value="rouge" @if(old('type_cartons_equipe2.'.$i, $cartons[$i]->type ?? null)=='rouge') selected @endif>Rouge</option>
                            </select>
                            <input type="number" name="minutes_cartons_equipe2[]" class="form-input w-20 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus-border-bl-accent transition" placeholder="Minute" value="{{ old('minutes_cartons_equipe2.'.$i, $cartons[$i]->minute ?? null) }}">
                            <button type="button" class="remove-carton bg-red-500 text-white px-2 rounded">X</button>
                        </div>
                    @endfor
                </div>
                <button type="button" id="add-carton-equipe2" class="bg-yellow-600 text-white px-2 py-1 rounded mt-2">+ Ajouter carton</button>
            </div>
        </div>
        <hr>
        <h3 class="text-lg font-semibold mt-4 mb-2 text-white">Homme du match (MVP)</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-semibold mb-1 text-white">
                    {{ $rencontre->equipe1->nom ?? '-' }}
                </label>
                <select name="mvp_equipe1_id" class="form-select w-full bg-bl-dark text-white">
                    <option value="">Aucun</option>
                    @foreach($joueursEquipe1 as $joueur)
                        <option value="{{ $joueur->id }}" @if(old('mvp_equipe1_id', $rencontre->mvp_id) == $joueur->id) selected @endif>{{ $joueur->nom }} {{ $joueur->prenom }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-1 text-white">
                    {{ $rencontre->equipe2->nom ?? '-' }}
                </label>
                <select name="mvp_equipe2_id" class="form-select w-full bg-bl-dark text-white">
                    <option value="">Aucun</option>
                    @foreach($joueursEquipe2 as $joueur)
                        <option value="{{ $joueur->id }}" @if(old('mvp_equipe2_id', $rencontre->mvp_id) == $joueur->id) selected @endif>{{ $joueur->nom }} {{ $joueur->prenom }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">Ne remplir qu’un seul champ MVP (un seul joueur ou nom sera retenu).</div>
        <div class="flex flex-wrap gap-4 mt-8 justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2 rounded shadow border border-green-600 transition">Enregistrer</button>
            <a href="{{ route('admin.rencontres.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-2 rounded shadow border border-yellow-500 transition">Annuler</a>
        </div>
    </form>
</div>
<div class="mt-8">
    @if($rencontre->equipe1)
        @livewire('effectif-match-form', ['matchId' => $rencontre->id, 'equipeId' => $rencontre->equipe1->id])
    @endif
    @if($rencontre->equipe2)
        @livewire('effectif-match-form', ['matchId' => $rencontre->id, 'equipeId' => $rencontre->equipe2->id])
    @endif
</div>
<div class="flex justify-end mt-8">
    <a href="{{ route('admin.rencontres.show', $rencontre) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-2 rounded shadow border border-yellow-500 transition inline-flex items-center">
        &#8592; Retour à la fiche de match
    </a>
</div>
@endsection

@push('scripts')
<script>
// Variables JS pour les joueurs, générées par Blade
var joueursEquipe1 = @json($joueursEquipe1 ?? []);
var joueursEquipe2 = @json($joueursEquipe2 ?? []);
document.addEventListener('DOMContentLoaded', function() {
    // Fonctions pour activer/désactiver les boutons buteur selon le score
    function updateButeurButtons() {
        const score1 = parseInt(document.querySelector('input[name="score_equipe1"]').value) || 0;
        const score2 = parseInt(document.querySelector('input[name="score_equipe2"]').value) || 0;
        const btnAddButeur1 = document.getElementById('add-buteur-equipe1');
        const btnAddButeur2 = document.getElementById('add-buteur-equipe2');
        if (btnAddButeur1) btnAddButeur1.disabled = (score1 === 0);
        if (btnAddButeur2) btnAddButeur2.disabled = (score2 === 0);
    }
    updateButeurButtons();
    document.querySelector('input[name="score_equipe1"]').addEventListener('input', updateButeurButtons);
    document.querySelector('input[name="score_equipe2"]').addEventListener('input', updateButeurButtons);

    // Ajouter buteur équipe 1
    const btnAddButeur1 = document.getElementById('add-buteur-equipe1');
    if (btnAddButeur1) {
        btnAddButeur1.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'flex flex-wrap gap-2 mb-2 buteur-row items-center';
            let select = '<select name="buteurs_equipe1[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus-border-bl-accent transition w-40">';
            select += '<option value="">Sélectionner un joueur</option>';
            joueursEquipe1.forEach(j => select += `<option value="${j.id}">${j.nom} ${j.prenom}</option>`);
            select += '</select>';
            div.innerHTML = select + '<input type="number" name="minutes_buteurs_equipe1[]" class="form-input w-24 bg-bl-dark text-white border-bl-border focus:ring-2 focus-ring-bl-accent focus-border-bl-accent transition" placeholder="Minute">' + '<button type="button" class="remove-buteur bg-red-500 text-white px-2 rounded">X</button>';
            document.getElementById('buteurs-equipe1-list').appendChild(div);
        });
    }
    // Ajouter buteur équipe 2
    const btnAddButeur2 = document.getElementById('add-buteur-equipe2');
    if (btnAddButeur2) {
        btnAddButeur2.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'flex flex-wrap gap-2 mb-2 buteur-row items-center';
            let select = '<select name="buteurs_equipe2[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus-ring-bl-accent focus-border-bl-accent transition w-40">';
            select += '<option value="">Sélectionner un joueur</option>';
            joueursEquipe2.forEach(j => select += `<option value="${j.id}">${j.nom} ${j.prenom}</option>`);
            select += '</select>';
            div.innerHTML = select + '<input type="number" name="minutes_buteurs_equipe2[]" class="form-input w-24 bg-bl-dark text-white border-bl-border focus:ring-2 focus-ring-bl-accent focus-border-bl-accent transition" placeholder="Minute">' + '<button type="button" class="remove-buteur bg-red-500 text-white px-2 rounded">X</button>';
            document.getElementById('buteurs-equipe2-list').appendChild(div);
        });
    }
    // Supprimer buteur équipe 1 (délégation)
    document.getElementById('buteurs-equipe1-list').addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-buteur')) e.target.parentNode.remove();
    });
    // Supprimer buteur équipe 2 (délégation)
    document.getElementById('buteurs-equipe2-list').addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-buteur')) e.target.parentNode.remove();
    });
    // Ajouter carton équipe 1
    const btnAddCarton1 = document.getElementById('add-carton-equipe1');
    if (btnAddCarton1) {
        btnAddCarton1.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'flex flex-wrap gap-2 mb-2 carton-row items-center';
            let select = '<select name="cartons_equipe1[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus-border-bl-accent transition w-40">';
            select += '<option value="">Sélectionner un joueur</option>';
            joueursEquipe1.forEach(j => select += `<option value="${j.id}">${j.nom} ${j.prenom}</option>`);
            select += '</select>';
            let type = '<select name="type_cartons_equipe1[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus-ring-bl-accent focus-border-bl-accent transition w-24"><option value="jaune">Jaune</option><option value="rouge">Rouge</option></select>';
            div.innerHTML = select + type + '<input type="number" name="minutes_cartons_equipe1[]" class="form-input w-20 bg-bl-dark text-white border-bl-border focus:ring-2 focus-ring-bl-accent focus-border-bl-accent transition" placeholder="Minute">' + '<button type="button" class="remove-carton bg-red-500 text-white px-2 rounded">X</button>';
            document.getElementById('cartons-equipe1-list').appendChild(div);
        });
    }
    // Ajouter carton équipe 2
    const btnAddCarton2 = document.getElementById('add-carton-equipe2');
    if (btnAddCarton2) {
        btnAddCarton2.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'flex flex-wrap gap-2 mb-2 carton-row items-center';
            let select = '<select name="cartons_equipe2[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus-ring-bl-accent focus-border-bl-accent transition w-40">';
            select += '<option value="">Sélectionner un joueur</option>';
            joueursEquipe2.forEach(j => select += `<option value="${j.id}">${j.nom} ${j.prenom}</option>`);
            select += '</select>';
            let type = '<select name="type_cartons_equipe2[]" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus-ring-bl-accent focus-border-bl-accent transition w-24"><option value="jaune">Jaune</option><option value="rouge">Rouge</option></select>';
            div.innerHTML = select + type + '<input type="number" name="minutes_cartons_equipe2[]" class="form-input w-20 bg-bl-dark text-white border-bl-border focus:ring-2 focus-ring-bl-accent focus-border-bl-accent transition" placeholder="Minute">' + '<button type="button" class="remove-carton bg-red-500 text-white px-2 rounded">X</button>';
            document.getElementById('cartons-equipe2-list').appendChild(div);
        });
    }
    // Supprimer carton équipe 1 (délégation)
    document.getElementById('cartons-equipe1-list').addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-carton')) e.target.parentNode.remove();
    });
    // Supprimer carton équipe 2 (délégation)
    document.getElementById('cartons-equipe2-list').addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-carton')) e.target.parentNode.remove();
    });
});
</script>
@endpush

