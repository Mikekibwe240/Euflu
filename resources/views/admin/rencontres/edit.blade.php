@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Modifier la rencontre</h2>
    <form id="form-rencontre" action="{{ route('admin.rencontres.update', $rencontre) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white dark:bg-gray-800 p-6 rounded shadow text-gray-900 dark:text-gray-100">
        @csrf
        @method('PUT')
        <div>
            <label for="pool_id" class="block font-semibold text-gray-900 dark:text-gray-100">Pool</label>
            <select name="pool_id" id="pool_id" class="form-select w-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" required>
                <option value="">Sélectionner un pool</option>
                @foreach($pools as $pool)
                    <option value="{{ $pool->id }}" {{ old('pool_id', $rencontre->pool_id) == $pool->id ? 'selected' : '' }}>{{ $pool->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="inline-flex items-center text-gray-900 dark:text-gray-100">
                <input type="checkbox" id="hors_calendrier" name="hors_calendrier" value="1" class="form-checkbox" {{ old('hors_calendrier', $rencontre->equipe1_libre || $rencontre->equipe2_libre ? 'checked' : '') }}>
                <span class="ml-2 font-semibold">Rencontre hors calendrier (amical ou externe)</span>
            </label>
        </div>
        <div class="flex gap-4">
            <div class="w-1/2">
                <label for="equipe1_id" class="block font-semibold">Équipe 1</label>
                <select name="equipe1_id" id="equipe1_id" class="form-select w-full" required>
                    <option value="">Sélectionner</option>
                    @foreach($equipes as $equipe)
                        <option value="{{ $equipe->id }}" data-pool="{{ $equipe->pool_id ?? 'libre' }}" {{ old('equipe1_id', $rencontre->equipe1_id) == $equipe->id ? 'selected' : '' }}>{{ $equipe->nom }} ({{ $equipe->pool->nom ?? 'Libre' }})</option>
                    @endforeach
                </select>
            </div>
            <div class="w-1/2">
                <label for="equipe2_id" class="block font-semibold">Équipe 2</label>
                <select name="equipe2_id" id="equipe2_id" class="form-select w-full" required>
                    <option value="">Sélectionner</option>
                    @foreach($equipes as $equipe)
                        <option value="{{ $equipe->id }}" data-pool="{{ $equipe->pool_id ?? 'libre' }}" {{ old('equipe2_id', $rencontre->equipe2_id) == $equipe->id ? 'selected' : '' }}>{{ $equipe->nom }} ({{ $equipe->pool->nom ?? 'Libre' }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-4">
            <div class="w-1/2">
                <label for="date" class="block font-semibold">Date</label>
                <input type="date" name="date" id="date" class="form-input w-full" value="{{ old('date', $rencontre->date) }}" required>
            </div>
            <div class="w-1/2">
                <label for="heure" class="block font-semibold">Heure</label>
                <input type="time" name="heure" id="heure" class="form-input w-full" value="{{ old('heure', $rencontre->heure) }}" required>
            </div>
        </div>
        <div>
            <label for="stade" class="block font-semibold">Stade</label>
            <select name="stade" id="stade" class="form-select w-full" required>
                @php
                    $stades = ['COKM', 'Annexe 1', 'Annexe 2', 'Jolie site', 'SGK'];
                    $currentStade = old('stade', $rencontre->stade);
                @endphp
                @foreach($stades as $stade)
                    <option value="{{ $stade }}" {{ $currentStade == $stade ? 'selected' : '' }}>{{ $stade }}</option>
                @endforeach
                @if($currentStade && !in_array($currentStade, $stades))
                    <option value="{{ $currentStade }}" selected>{{ $currentStade }} (autre)</option>
                @endif
            </select>
        </div>
        <div>
            <label for="journee" class="block font-semibold">Journée (optionnel)</label>
            @if($rencontre->score_equipe1 === null && $rencontre->score_equipe2 === null)
                <input type="number" name="journee" id="journee" class="form-input w-full" value="{{ old('journee', $rencontre->journee) }}">
            @else
                <input type="number" name="journee" id="journee" class="form-input w-full bg-gray-100 text-gray-400" value="{{ old('journee', $rencontre->journee) }}" disabled>
                <input type="hidden" name="journee" value="{{ $rencontre->journee }}">
            @endif
        </div>
        <!-- Champ Type de rencontre -->
        <div id="type_rencontre_block" class="mb-4">
            <label class="block font-semibold">Type de rencontre <span class="text-red-500">*</span></label>
            <select name="type_rencontre" id="type_rencontre" class="form-select w-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700">
                <option value="amical" {{ old('type_rencontre', $rencontre->type_rencontre ?? '') == 'amical' ? 'selected' : '' }}>Amical</option>
                <option value="externe" {{ old('type_rencontre', $rencontre->type_rencontre ?? '') == 'externe' ? 'selected' : '' }}>Externe</option>
            </select>
        </div>
        <div id="mvp_block" class="mb-4" style="display: none;">
            <label for="mvp_libre_equipe" class="block font-semibold">Équipe de l'homme du match (si externe)</label>
            <input type="text" name="mvp_libre_equipe" id="mvp_libre_equipe" class="form-input w-full" value="{{ old('mvp_libre_equipe', $rencontre->mvp_libre_equipe) }}" placeholder="Nom de l'équipe du MVP (si externe)">
        </div>
        <div id="form-error" class="text-red-600 font-semibold text-sm"></div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
            <a href="{{ route('admin.rencontres.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
        </div>
    </form>
</div>
<script>
function updateFormUX() {
    const horsCalendrier = document.getElementById('hors_calendrier').checked;
    // Afficher/cacher le champ Type de rencontre
    document.getElementById('type_rencontre_block').style.display = horsCalendrier ? 'none' : '';
    document.getElementById('type_rencontre').required = !horsCalendrier;
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
                opt.style.display = (opt.dataset.pool === poolId) ? '' : 'none';
            }
        });
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
</script>
@endsection