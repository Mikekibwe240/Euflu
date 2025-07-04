<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded shadow p-6 mt-8">
    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Effectif du match : {{ $match->equipe1->nom }} vs {{ $match->equipe2->nom }}<br><span class="text-base font-normal text-gray-500 dark:text-gray-300">Équipe : {{ $equipe->nom }}</span></h2>
    @if (session()->has('success'))
        <div class="mb-4 p-2 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">{{ session('success') }}</div>
    @endif
    <form wire:submit.prevent="save">
        <div class="mb-6">
            <label class="block font-semibold mb-2 text-gray-800 dark:text-gray-100">Titulaires (11 joueurs)</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($joueurs as $joueur)
                    <label class="flex items-center space-x-2 text-gray-800 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                        <input type="checkbox" wire:model="titulaires" value="{{ $joueur->id }}" @if(in_array($joueur->id, $remplacants)) disabled @endif>
                        <span>{{ $joueur->nom }}</span>
                    </label>
                @endforeach
            </div>
            @error('titulaires') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="mb-6">
            <label class="block font-semibold mb-2 text-gray-800 dark:text-gray-100">Remplaçants (max 5)</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($joueurs as $joueur)
                    <label class="flex items-center space-x-2 text-gray-800 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                        <input type="checkbox" wire:model="remplacants" value="{{ $joueur->id }}" @if(in_array($joueur->id, $titulaires)) disabled @endif>
                        <span>{{ $joueur->nom }}</span>
                    </label>
                @endforeach
            </div>
            @error('remplacants') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="mb-6">
            <label class="block font-semibold mb-2 text-gray-800 dark:text-gray-100">Remplacements (pour chaque remplaçant, qui a-t-il remplacé ?)</label>
            <div class="space-y-2">
                @foreach($remplacants as $remplacantId)
                    <div class="flex flex-col md:flex-row md:items-center md:space-x-2 space-y-2 md:space-y-0 text-gray-800 dark:text-gray-100">
                        <div class="flex items-center space-x-2">
                            <span class="font-medium">{{ $joueurs->find($remplacantId)?->nom }}</span>
                            <span>→</span>
                            @if(count($titulaires) > 0)
                                <select wire:model="remplacements.{{ $remplacantId }}.joueur" class="border rounded px-2 py-1 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                                    <option value="">-- Choisir le joueur remplacé --</option>
                                    @foreach($titulaires as $titulaireId)
                                        <option value="{{ $titulaireId }}">{{ $joueurs->find($titulaireId)?->nom }}</option>
                                    @endforeach
                                </select>
                            @else
                                <span class="italic text-gray-500">Sélectionnez d'abord les titulaires</span>
                            @endif
                        </div>
                        <input type="number" min="1" max="120" wire:model="remplacements.{{ $remplacantId }}.minute" class="border rounded px-2 py-1 w-24 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100" placeholder="Minute">
                    </div>
                    @error('remplacements.' . $remplacantId . '.joueur') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    @error('remplacements.' . $remplacantId . '.minute') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                @endforeach
            </div>
        </div>
        @if($errors->any())
            <div class="mb-4 p-2 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Enregistrer l'effectif</button>
    </form>
</div>
