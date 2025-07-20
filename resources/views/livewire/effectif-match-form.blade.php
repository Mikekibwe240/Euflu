<div class="max-w-4xl mx-auto bg-bl-card border border-bl-border rounded-xl shadow-lg p-8 mt-8">
    <h2 class="text-xl font-bold mb-4 text-bl-accent">Effectif du match : {{ $match->equipe1->nom }} vs {{ $match->equipe2->nom }}<br><span class="text-base font-normal text-gray-400">Équipe : {{ $equipe->nom }}</span></h2>
    @if (session()->has('success'))
        <div class="mb-4 p-2 bg-green-900/80 text-green-200 border border-green-700 rounded">{{ session('success') }}</div>
    @endif
    <form wire:submit.prevent="save">
        <div class="mb-6">
            <label class="block font-semibold mb-2 text-white">Titulaires (11 joueurs)</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($joueurs as $joueur)
                    <label class="flex items-center space-x-2 text-white bg-bl-dark px-2 py-1 rounded">
                        <input type="checkbox" wire:model="titulaires" value="{{ $joueur->id }}" @if(in_array($joueur->id, $remplacants)) disabled @endif>
                        @if($joueur->photo)
                            <img src="{{ asset('storage/' . $joueur->photo) }}" alt="{{ $joueur->nom }}" class="w-8 h-8 rounded-full object-cover mr-2" onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 mr-2\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#b0b0b0\' viewBox=\'0 0 24 24\' class=\'w-6 h-6\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z\'/></svg></div>'">
                        @else
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="w-6 h-6"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/></svg>
                            </div>
                        @endif
                        <span>{{ $joueur->nom }} {{ $joueur->prenom }}</span>
                    </label>
                @endforeach
            </div>
            @error('titulaires') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="mb-6">
            <label class="block font-semibold mb-2 text-white">Remplaçants (max 5)</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($joueurs as $joueur)
                    <label class="flex items-center space-x-2 text-white bg-bl-dark px-2 py-1 rounded">
                        <input type="checkbox" wire:model="remplacants" value="{{ $joueur->id }}" @if(in_array($joueur->id, $titulaires)) disabled @endif>
                        @if($joueur->photo)
                            <img src="{{ asset('storage/' . $joueur->photo) }}" alt="{{ $joueur->nom }}" class="w-8 h-8 rounded-full object-cover mr-2" onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 mr-2\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#b0b0b0\' viewBox=\'0 0 24 24\' class=\'w-6 h-6\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z\'/></svg></div>'">
                        @else
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="w-6 h-6"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/></svg>
                            </div>
                        @endif
                        <span>{{ $joueur->nom }} {{ $joueur->prenom }}</span>
                    </label>
                @endforeach
            </div>
            @error('remplacants') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="mb-6">
            <label class="block font-semibold mb-2 text-white">Remplacements (pour chaque remplaçant, qui a-t-il remplacé ?)</label>
            <div class="space-y-2">
                @foreach($remplacants as $remplacantId)
                    <div class="flex flex-col md:flex-row md:items-center md:space-x-2 space-y-2 md:space-y-0 text-white">
                        <div class="flex items-center space-x-2">
                            @php $remplacant = $joueurs->find($remplacantId); @endphp
                            @if($remplacant && $remplacant->photo)
                                <img src="{{ asset('storage/' . $remplacant->photo) }}" alt="{{ $remplacant->nom }}" class="w-8 h-8 rounded-full object-cover mr-2" onerror="this.style.display='none'; this.parentNode.innerHTML='<div class=\'w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 mr-2\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#b0b0b0\' viewBox=\'0 0 24 24\' class=\'w-6 h-6\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z\'/></svg></div>'">
                            @else
                                <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-700 mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="w-6 h-6"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/></svg>
                                </div>
                            @endif
                            <span class="font-medium">{{ $remplacant?->nom }} {{ $remplacant?->prenom }}</span>
                            <span>→</span>
                            @if(count($titulaires) > 0)
                                <select wire:model="remplacements.{{ $remplacantId }}.joueur" class="form-select bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent rounded px-2 py-1">
                                    <option value="">-- Choisir le joueur remplacé --</option>
                                    @foreach($titulaires as $titulaireId)
                                        @php $titulaire = $joueurs->find($titulaireId); @endphp
                                        <option value="{{ $titulaireId }}">
                                            @if($titulaire && $titulaire->photo)
                                                <img src="{{ asset('storage/' . $titulaire->photo) }}" alt="{{ $titulaire->nom }}" class="inline w-6 h-6 rounded-full object-cover mr-1" onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'inline-block w-6 h-6 rounded-full bg-gray-700 mr-1\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#b0b0b0\' viewBox=\'0 0 24 24\' class=\'w-4 h-4\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z\'/></svg></span>'">
                                            @else
                                                <span class="inline-block w-6 h-6 rounded-full bg-gray-700 mr-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#b0b0b0" viewBox="0 0 24 24" class="w-4 h-4"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-3.313 3.134-6 7-6s7 2.687 7 6v1H4v-1z"/></svg>
                                                </span>
                                            @endif
                                            {{ $titulaire?->nom }} {{ $titulaire?->prenom }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <span class="italic text-gray-400">Sélectionnez d'abord les titulaires</span>
                            @endif
                        </div>
                        <input type="number" min="1" max="120" wire:model="remplacements.{{ $remplacantId }}.minute" class="form-input w-24 bg-bl-dark text-white border-bl-border focus:ring-2 focus:ring-bl-accent focus:border-bl-accent rounded px-2 py-1" placeholder="Minute">
                    </div>
                    @error('remplacements.' . $remplacantId . '.joueur') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    @error('remplacements.' . $remplacantId . '.minute') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                @endforeach
            </div>
        </div>
        @if($errors->any())
            <div class="mb-4 p-2 bg-red-900/80 text-red-200 border border-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow border border-green-600 transition">Enregistrer l'effectif</button>
    </form>
</div>
