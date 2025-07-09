@extends('layouts.admin')

@section('title', 'Transferts de joueurs')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <button onclick="window.history.back()" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 border border-yellow-500 transition">← Retour</button>
    <h1 class="text-2xl font-bold mb-6 text-bl-accent">Transferts de joueurs</h1>
    @if(session('success'))
        <x-alert type="success" :message="session('success')" class="mb-6" />
    @endif
    <form method="POST" action="{{ route('admin.transferts.store') }}" class="space-y-6 bg-bl-card p-6 rounded-lg shadow border border-bl-border">
        @csrf
        <div>
            <label class="block font-semibold mb-2 text-white">Rechercher un joueur à transférer</label>
            <input type="text" name="joueur_search" id="joueur_search" placeholder="Nom, prénom..." autocomplete="off" class="w-full px-4 py-2 border border-bl-border rounded bg-gray-800 text-white focus:ring-2 focus:ring-bl-accent">
            <div id="joueur_results" class="mt-2"></div>
        </div>
        <div>
            <label class="block font-semibold mb-2 text-white">Nouvelle équipe (ou libre)</label>
            <input type="text" name="equipe_search" id="equipe_search" placeholder="Nom de l'équipe... ou tapez 'libre'" autocomplete="off" class="w-full px-4 py-2 border border-bl-border rounded bg-gray-800 text-white focus:ring-2 focus:ring-bl-accent">
            <div id="equipe_results" class="mt-2"></div>
        </div>
        <input type="hidden" name="joueur_id" id="joueur_id">
        <input type="hidden" name="equipe_id" id="equipe_id">
        <button type="submit" class="px-6 py-2 bg-bl-accent text-white rounded font-bold hover:bg-bl-dark hover:text-bl-accent border border-bl-accent transition">Valider le transfert</button>
    </form>
</div>
<script>
// Correction robuste : préparer les tableaux JSON côté contrôleur Laravel (pas dans la vue)
const joueurs = @json($joueurs_json);
const equipes = @json($equipes_json);
function renderJoueurResults(list) {
    return list.length ? list.map(j => `<div class='flex items-center gap-3 p-2 hover:bg-gray-100 cursor-pointer' onclick='selectJoueur(${j.id})'>${j.photo?`<img src='/storage/${j.photo}' class='h-8 w-8 rounded-full object-cover'>`:`<div class='h-8 w-8 rounded-full bg-gray-700 flex items-center justify-center'><svg xmlns='http://www.w3.org/2000/svg' fill='#b0b0b0' viewBox='0 0 24 24' class='h-6 w-6'><circle cx='12' cy='8' r='4'/><path d='M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z'/></svg></div>`}<span class='font-bold'>${j.nom}</span> <span>${j.prenom}</span> <span class='text-xs text-gray-500 ml-2'>${j.equipe?j.equipe.nom:'Libre'}</span></div>`).join('') : "<div class='text-gray-500 p-2'>Aucun joueur trouvé</div>";
}
function renderEquipeResults(list) {
    return list.length ? list.map(e => `<div class='flex items-center gap-3 p-2 hover:bg-gray-100 cursor-pointer' onclick='selectEquipe(${e.id})'>${e.logo?`<img src='/storage/${e.logo}' class='h-8 w-8 rounded-full object-cover'>`:`<span class='inline-flex items-center justify-center h-8 w-8 rounded-full bg-[#23272a]'><svg xmlns='http://www.w3.org/2000/svg' fill='#e2001a' viewBox='0 0 24 24' style='height:16px;width:16px;'><circle cx='12' cy='12' r='10' fill='#23272a'/><path d='M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z' fill='#e2001a'/><circle cx='12' cy='12' r='3' fill='#fff'/></svg></span>`}<span class='font-bold'>${e.nom}</span></div>`).join('') : "<div class='text-gray-500 p-2'>Aucune équipe trouvée</div>";
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
