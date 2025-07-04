@extends('layouts.admin')
@section('title', 'Transferts de joueurs')
@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Transferts de joueurs</h1>
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('admin.transferts.store') }}" class="space-y-6">
        @csrf
        <div>
            <label class="block font-semibold mb-2">Rechercher un joueur à transférer</label>
            <input type="text" name="joueur_search" id="joueur_search" placeholder="Nom, prénom..." autocomplete="off" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500">
            <div id="joueur_results" class="mt-2"></div>
        </div>
        <div>
            <label class="block font-semibold mb-2">Nouvelle équipe (ou libre)</label>
            <input type="text" name="equipe_search" id="equipe_search" placeholder="Nom de l'équipe... ou tapez 'libre'" autocomplete="off" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500">
            <div id="equipe_results" class="mt-2"></div>
        </div>
        <input type="hidden" name="joueur_id" id="joueur_id">
        <input type="hidden" name="equipe_id" id="equipe_id">
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded font-bold hover:bg-blue-700">Valider le transfert</button>
    </form>
</div>
<script>
// Simuler une recherche AJAX (à remplacer par un vrai endpoint si besoin)
const joueurs = @json($joueurs->map(function($j){
    return [
        'id' => $j->id,
        'nom' => $j->nom,
        'prenom' => $j->prenom,
        'photo' => $j->photo,
        'equipe' => $j->equipe ? ['nom' => $j->equipe->nom, 'logo' => $j->equipe->logo] : null
    ];
})->values());
const equipes = @json($equipes->map(function($e){
    return [
        'id' => $e->id,
        'nom' => $e->nom,
        'logo' => $e->logo
    ];
})->values());
function renderJoueurResults(list) {
    return list.length ? list.map(j => `<div class='flex items-center gap-3 p-2 hover:bg-gray-100 cursor-pointer' onclick='selectJoueur(${j.id})'>${j.photo?`<img src='/storage/${j.photo}' class='h-8 w-8 rounded-full object-cover'>`:`<div class='h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center'><svg width='20' height='20'><circle cx='10' cy='10' r='10' fill='#bbb'/></svg></div>`}<span class='font-bold'>${j.nom}</span> <span>${j.prenom}</span> <span class='text-xs text-gray-500 ml-2'>${j.equipe?j.equipe.nom:'Libre'}</span></div>`).join('') : "<div class='text-gray-500 p-2'>Aucun joueur trouvé</div>";
}
function renderEquipeResults(list) {
    return list.length ? list.map(e => `<div class='flex items-center gap-3 p-2 hover:bg-gray-100 cursor-pointer' onclick='selectEquipe(${e.id})'>${e.logo?`<img src='/storage/${e.logo}' class='h-8 w-8 rounded-full object-cover'>`:`<div class='h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center'><svg width='20' height='20'><circle cx='10' cy='10' r='10' fill='#bbb'/></svg></div>`}<span class='font-bold'>${e.nom}</span></div>`).join('') : "<div class='text-gray-500 p-2'>Aucune équipe trouvée</div>";
}
document.getElementById('joueur_search').addEventListener('input', function() {
    const val = this.value.toLowerCase();
    const filtered = joueurs.filter(j => j.nom.toLowerCase().includes(val) || j.prenom.toLowerCase().includes(val));
    document.getElementById('joueur_results').innerHTML = renderJoueurResults(filtered);
});
window.selectJoueur = function(id) {
    const j = joueurs.find(j => j.id === id);
    document.getElementById('joueur_id').value = j.id;
    document.getElementById('joueur_search').value = j.nom + ' ' + j.prenom;
    document.getElementById('joueur_results').innerHTML = '';
};
document.getElementById('equipe_search').addEventListener('input', function() {
    const val = this.value.toLowerCase();
    if(val === 'libre') {
        document.getElementById('equipe_id').value = '';
        document.getElementById('equipe_results').innerHTML = `<div class='flex items-center gap-3 p-2 bg-yellow-100 rounded'><span class='font-bold text-yellow-700'>Libre (sans équipe)</span></div>`;
        return;
    }
    const filtered = equipes.filter(e => e.nom.toLowerCase().includes(val));
    document.getElementById('equipe_results').innerHTML = renderEquipeResults(filtered);
});
window.selectEquipe = function(id) {
    const e = equipes.find(e => e.id === id);
    document.getElementById('equipe_id').value = e.id;
    document.getElementById('equipe_search').value = e.nom;
    document.getElementById('equipe_results').innerHTML = '';
};
</script>
@endsection
