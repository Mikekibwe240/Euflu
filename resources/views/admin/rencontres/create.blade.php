@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-bl-card border border-bl-border rounded-xl shadow-lg p-8 mt-8">
    <h2 class="text-2xl font-extrabold mb-6 text-bl-accent tracking-wide">Ajouter une rencontre</h2>
    @if($errors->any())
        <div class="bg-red-900/80 text-white border border-red-700 p-3 mb-6 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="form-rencontre" action="{{ route('admin.rencontres.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div>
            <label class="inline-flex items-center">
                <input type="checkbox" id="hors_calendrier" name="hors_calendrier" value="1" class="form-checkbox accent-bl-accent" {{ old('hors_calendrier') ? 'checked' : '' }}>
                <span class="ml-2 font-semibold text-bl-accent">Rencontre hors calendrier (amical ou externe)</span>
            </label>
        </div>
        <div id="pool_journee_block">
            <div class="mb-4">
                <label for="pool_id" class="block text-white font-semibold mb-1">Pool <span class="text-red-500">*</span></label>
                <select name="pool_id" id="pool_id" class="w-full p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required>
                    <option value="">Sélectionner</option>
                    @foreach($pools as $pool)
                        <option value="{{ $pool->id }}" {{ old('pool_id') == $pool->id ? 'selected' : '' }}>{{ $pool->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="journee" class="block text-white font-semibold mb-1">Journée <span class="text-red-500">*</span></label>
                <input type="number" name="journee" id="journee" class="w-full p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" value="{{ old('journee') }}" required>
            </div>
        </div>
        <div class="flex gap-4">
            <div class="w-1/2">
                <label class="block text-white font-semibold mb-1">Équipe 1 <span class="text-red-500">*</span></label>
                <select name="equipe1_id" id="equipe1_id" class="w-full mb-2 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required>
                    <option value="">Sélectionner</option>
                    @foreach($equipes as $equipe)
                        <option value="{{ $equipe->id }}" data-pool="{{ $equipe->pool_id ?? 'libre' }}">{{ $equipe->nom }} ({{ $equipe->pool->nom ?? 'Libre' }})</option>
                    @endforeach
                </select>
            </div>
            <div class="w-1/2">
                <label class="block text-white font-semibold mb-1">Équipe 2 <span class="text-red-500">*</span></label>
                <select name="equipe2_id" id="equipe2_id" class="w-full mb-2 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required>
                    <option value="">Sélectionner</option>
                    @foreach($equipes as $equipe)
                        <option value="{{ $equipe->id }}" data-pool="{{ $equipe->pool_id ?? 'libre' }}">{{ $equipe->nom }} ({{ $equipe->pool->nom ?? 'Libre' }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-4">
            <div class="w-1/2">
                <label for="date" class="block text-white font-semibold mb-1">Date <span class="text-red-500">*</span></label>
                <input type="date" name="date" id="date" class="w-full p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required>
            </div>
            <div class="w-1/2">
                <label for="heure" class="block text-white font-semibold mb-1">Heure <span class="text-red-500">*</span></label>
                <input type="time" name="heure" id="heure" class="w-full p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" required>
            </div>
        </div>
        <div>
            <label for="stade" class="block text-white font-semibold mb-1">Stade <span class="text-red-500">*</span></label>
            @php
                $stades = ['COKM', 'Annexe 1', 'Annexe 2', 'Jolie site', 'SGK'];
                $currentStade = old('stade');
            @endphp
            <select name="stade_select" id="stade_select" class="w-full p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition">
                <option value="">Sélectionner un stade</option>
                @foreach($stades as $stade)
                    <option value="{{ $stade }}" {{ $currentStade == $stade ? 'selected' : '' }}>{{ $stade }}</option>
                @endforeach
                @if($currentStade && !in_array($currentStade, $stades))
                    <option value="{{ $currentStade }}" selected>{{ $currentStade }} (autre)</option>
                @endif
            </select>
            <input type="text" name="stade" id="stade" class="w-full mt-2 p-3 border border-bl-border rounded bg-bl-dark text-white focus:ring-2 focus:ring-bl-accent focus:border-bl-accent transition" placeholder="Autre stade..." value="{{ $currentStade && !in_array($currentStade, $stades) ? $currentStade : '' }}">
        </div>
        <div id="form-error" class="text-red-400 font-semibold text-sm"></div>
        <div class="flex items-center gap-4 mt-6">
            <button type="submit" class="bg-bl-accent hover:bg-bl-dark text-white font-bold px-6 py-2 rounded shadow border border-bl-accent transition">Enregistrer</button>
            <a href="{{ route('admin.rencontres.index') }}" class="text-gray-400 hover:text-bl-accent underline transition">Annuler</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function updateFormUX() {
    const horsCalendrier = document.getElementById('hors_calendrier').checked;
    // Afficher/cacher pool/journee
    document.getElementById('pool_journee_block').style.display = horsCalendrier ? 'none' : '';
    document.getElementById('pool_id').required = !horsCalendrier;
    document.getElementById('journee').required = !horsCalendrier;
    // Filtrage dynamique des équipes
    const poolId = document.getElementById('pool_id').value;
    [1,2].forEach(num => {
        const select = document.getElementById('equipe'+num+'_id');
        Array.from(select.options).forEach(opt => {
            if (!opt.value) return;
            if (horsCalendrier) {
                opt.style.display = '';
            } else {
                // Si aucun pool sélectionné, masquer toutes les équipes
                if (!poolId) {
                    opt.style.display = 'none';
                } else {
                    // Si pool sélectionné, ne montrer que les équipes du pool
                    opt.style.display = (opt.dataset.pool === poolId) ? '' : 'none';
                }
            }
        });
        // Reset si sélection non valide
        if (!horsCalendrier && select.value && select.options[select.selectedIndex].style.display === 'none') {
            select.value = '';
        }
    });
}
document.getElementById('hors_calendrier').addEventListener('change', updateFormUX);
document.getElementById('pool_id').addEventListener('change', updateFormUX);
window.addEventListener('DOMContentLoaded', function() {
    updateFormUX();
});
// Validation JS personnalisée simplifiée
const form = document.getElementById('form-rencontre');
form.addEventListener('submit', function(e) {
    const horsCalendrier = document.getElementById('hors_calendrier').checked;
    let error = '';
    if (!horsCalendrier) {
        if (!document.getElementById('pool_id').value) error = 'Veuillez sélectionner un pool.';
        else if (!document.getElementById('journee').value) error = 'Veuillez indiquer la journée.';
    }
    if (!document.getElementById('equipe1_id').value) error = 'Veuillez sélectionner l\'équipe 1.';
    if (!document.getElementById('equipe2_id').value) error = 'Veuillez sélectionner l\'équipe 2.';
    if (error) {
        document.getElementById('form-error').textContent = error;
        e.preventDefault();
        return false;
    } else {
        document.getElementById('form-error').textContent = '';
    }
});
document.getElementById('stade_select').addEventListener('change', function() {
    const val = this.value;
    document.getElementById('stade').value = val;
});
document.getElementById('stade').addEventListener('input', function() {
    if (this.value && !Array.from(document.getElementById('stade_select').options).some(opt => opt.value === this.value)) {
        document.getElementById('stade_select').value = '';
    }
});
</script>
@endsection
