@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Générer le calendrier des matchs</h2>
    @if(session('success'))
        <x-alert type="success">
            {{ session('success') }}
            @if(session('resume'))
                <div class="mt-2 text-sm">
                    <strong>Résumé :</strong><br>
                    Pool : <span class="font-semibold">{{ session('resume.pool') }}</span><br>
                    Nombre de matchs générés : <span class="font-semibold">{{ session('resume.nb_matchs') }}</span><br>
                    Équipes :
                    <ul class="list-disc ml-6">
                        @foreach(session('resume.equipes', []) as $equipe)
                            <li>{{ $equipe }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </x-alert>
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if($errors->any())
        <x-alert type="error" :message="$errors->first()" />
    @endif
    @if(session('error_force'))
        <x-alert type="warning">
            {{ session('error_force.message') }}
            <form action="{{ route('admin.rencontres.generer', ['pool_id' => session('error_force.pool_id')]) }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="forcer" value="1">
                <button type="submit" class="ml-2 bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">Oui, supprimer et régénérer</button>
            </form>
            <a href="{{ url()->current() }}" class="ml-2 underline text-sm text-gray-600 hover:text-gray-900">Non, annuler</a>
        </x-alert>
    @endif
    <form action="{{ route('admin.rencontres.generer', ['pool_id' => null]) }}" method="POST" id="form-generer">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold text-gray-900 dark:text-gray-100 mb-1">Pool</label>
            <select name="pool_id" class="form-select w-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" required>
                <option value="">Sélectionner un pool</option>
                @foreach($pools as $pool)
                    <option value="{{ $pool->id }}">{{ $pool->nom }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition flex items-center justify-center gap-2" id="btn-generer">
            <span>Générer le calendrier</span>
            <svg id="spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
        </button>
    </form>
    <div id="chart-container" class="mt-8"></div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Spinner sur le bouton
const form = document.getElementById('form-generer');
const btn = document.getElementById('btn-generer');
const spinner = document.getElementById('spinner');
if(form && btn && spinner) {
    form.addEventListener('submit', function() {
        btn.setAttribute('disabled', 'disabled');
        spinner.classList.remove('hidden');
    });
}
// Affichage graphique si données disponibles
@if(session('resume'))
    const equipes = @json(session('resume.equipes'));
    const nbMatchs = @json(session('resume.nb_matchs'));
    const ctx = document.createElement('canvas');
    ctx.id = 'chart-equipes';
    document.getElementById('chart-container').appendChild(ctx);
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: equipes,
            datasets: [{
                label: 'Nombre de matchs (total)',
                data: Array(equipes.length).fill(Math.round(nbMatchs / equipes.length)),
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Répartition des matchs par équipe (approx.)' }
            }
        }
    });
@endif
</script>
@endpush
