@foreach($equipes as $equipe)
    <a href="{{ route('equipes.show', ['equipe' => $equipe->id]) }}" class="block bg-[#23272a] rounded-lg shadow-lg p-6 hover:bg-[#181d1f] transition group border border-[#31363a] min-w-0 mb-2">
        <div class="flex items-center gap-4 mb-2 min-w-0">
            <x-team-logo :team="$equipe" :size="48" />
            <span class="font-extrabold text-white text-lg group-hover:text-[#6fcf97] truncate">{{ $equipe->nom }}</span>
        </div>
        <div class="text-gray-400 text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
            {{ $equipe->stade ?? 'Stade inconnu' }}
        </div>
    </a>
@endforeach
@if($equipes->isEmpty())
    <div class="text-gray-400 italic">Aucune équipe trouvée.</div>
@endif
