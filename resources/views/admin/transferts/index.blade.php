@extends('layouts.admin')

@section('title', 'Transferts de joueurs')

@section('header')
    Gestion des Transferts
@endsection

@section('content')
<div class="container mx-auto py-8">
    <button onclick="window.history.back()" class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 transition">← Retour</button>
    <h2 class="text-2xl font-semibold text-blue-700 dark:text-blue-300 mb-6">Transferts de joueurs</h2>
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mb-8">
        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif
        @if(session('error'))
            <x-alert type="error" :message="session('error')" />
        @endif
        <div class="mb-6 flex flex-col md:flex-row gap-6">
            <div class="flex-1">
                <h3 class="text-lg font-bold text-blue-700 dark:text-blue-300 mb-2">Transférer un joueur</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Sélectionnez un joueur d'une équipe pour le transférer vers une autre équipe ou le rendre libre.</p>
                <form action="{{ route('admin.transferts.store') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <div class="mb-4">
                        <label for="pool_select" class="block font-semibold mb-1">Poule</label>
                        <select id="pool_select" class="p-2 border rounded w-full dark:bg-gray-700 dark:text-white mb-2">
                            <option value="">Sélectionner une poule</option>
                            <option value="libre">Libre</option>
                            @foreach($pools as $pool)
                                <option value="{{ $pool->id }}">{{ $pool->nom }}</option>
                            @endforeach
                        </select>
                        <label for="equipe_select" class="block font-semibold mb-1">Équipe</label>
                        <select id="equipe_select" class="p-2 border rounded w-full dark:bg-gray-700 dark:text-white mb-2">
                            <option value="">Sélectionner une équipe</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="joueur_id" value="Joueur à transférer" />
                        <select name="joueur_id" id="joueur_id" class="p-2 border rounded w-full dark:bg-gray-700 dark:text-white" required>
                            <option value="">Sélectionner un joueur</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="equipe_id" value="Nouvelle équipe (ou libre)" />
                        <select name="equipe_id" id="equipe_id" class="p-2 border rounded w-full dark:bg-gray-700 dark:text-white">
                            <option value="">Libre (sans équipe)</option>
                            @foreach($equipes as $equipe)
                                <option value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-primary-button class="bg-gradient-to-r from-blue-600 to-blue-400 hover:from-blue-700 hover:to-blue-500 text-white font-bold shadow-lg">Transférer</x-primary-button>
                </form>
            </div>
            <div class="flex-1 border-l border-gray-200 dark:border-gray-700 pl-6">
                <h3 class="text-lg font-bold text-green-700 dark:text-green-300 mb-2">Affecter un joueur libre</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Sélectionnez un joueur sans équipe pour l'affecter à une équipe.</p>
                <form action="{{ route('admin.transferts.store') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <div>
                        <x-input-label for="joueur_libre_id" value="Joueur libre" />
                        <select name="joueur_id" id="joueur_libre_id" class="p-2 border rounded w-full dark:bg-gray-700 dark:text-white" required>
                            <option value="">Sélectionner un joueur libre</option>
                            @foreach($joueurs->where('equipe_id', null) as $joueur)
                                <option value="{{ $joueur->id }}">
                                    {{ $joueur->nom }} {{ $joueur->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="equipe_libre_id" value="Équipe à affecter" />
                        <select name="equipe_id" id="equipe_libre_id" class="p-2 border rounded w-full dark:bg-gray-700 dark:text-white" required>
                            <option value="">Sélectionner une équipe</option>
                            @foreach($equipes as $equipe)
                                <option value="{{ $equipe->id }}">{{ $equipe->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-primary-button class="bg-gradient-to-r from-green-600 to-green-400 hover:from-green-700 hover:to-green-500 text-white font-bold shadow-lg">Affecter</x-primary-button>
                </form>
            </div>
        </div>
        <div class="mt-8">
            <h4 class="text-md font-semibold text-gray-700 dark:text-gray-200 mb-2">Conseils d'utilisation :</h4>
            <ul class="list-disc pl-6 text-gray-600 dark:text-gray-400 text-sm">
                <li>Pour libérer un joueur, sélectionnez-le dans la colonne de gauche et choisissez "Libre (sans équipe)".</li>
                <li>Pour transférer un joueur, sélectionnez-le dans la colonne de gauche et choisissez une nouvelle équipe.</li>
                <li>Pour affecter un joueur libre, utilisez la colonne de droite.</li>
            </ul>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const poolSelect = document.getElementById('pool_select');
    const equipeSelect = document.getElementById('equipe_select');
    const joueurSelect = document.getElementById('joueur_id');
    const pools = @json($pools);
    const equipes = @json($equipes);

    function updateEquipes() {
        const poolId = poolSelect.value;
        equipeSelect.innerHTML = '<option value="">Sélectionner une équipe</option>';
        joueurSelect.innerHTML = '<option value="">Sélectionner un joueur</option>';
        if (!poolId) return;
        if (poolId === 'libre') {
            // Afficher uniquement les équipes libres (pool_id null)
            equipes.filter(e => !e.pool_id).forEach(equipe => {
                equipeSelect.innerHTML += `<option value="${equipe.id}">${equipe.nom}</option>`;
            });
            return;
        }
        const pool = pools.find(p => p.id == poolId);
        if (!pool) return;
        pool.equipes.forEach(equipe => {
            equipeSelect.innerHTML += `<option value="${equipe.id}">${equipe.nom}</option>`;
        });
    }
    function updateJoueurs() {
        const poolId = poolSelect.value;
        const equipeId = equipeSelect.value;
        joueurSelect.innerHTML = '<option value="">Sélectionner un joueur</option>';
        if (!poolId || !equipeId) return;
        const pool = pools.find(p => p.id == poolId);
        if (!pool) return;
        const equipe = pool.equipes.find(e => e.id == equipeId);
        if (!equipe) return;
        equipe.joueurs.forEach(joueur => {
            joueurSelect.innerHTML += `<option value="${joueur.id}">${joueur.nom} ${joueur.prenom}</option>`;
        });
    }
    if (poolSelect && equipeSelect && joueurSelect) {
        poolSelect.addEventListener('change', updateEquipes);
        equipeSelect.addEventListener('change', updateJoueurs);
    }
});
</script>
@endsection
