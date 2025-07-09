@if($equipes->isEmpty())
    <tr><td colspan="4" class="text-center text-gray-400 italic py-4">Aucune équipe trouvée.</td></tr>
@else
    @foreach($equipes as $equipe)
        <tr class="border-b border-gray-200 dark:border-gray-700 text-center align-middle hover:bg-blue-50 dark:hover:bg-blue-900 transition cursor-pointer @if(is_null($equipe->pool_id)) bg-yellow-50 dark:bg-yellow-900 @endif" onclick="window.location='{{ route('admin.equipes.show', $equipe) }}'">
            <td class="py-2 px-4 text-center">
                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full border border-gray-200 dark:border-gray-700 overflow-hidden bg-white align-middle">
                    @if($equipe->logo)
                        <img src="{{ asset('storage/' . $equipe->logo) }}" alt="Logo" class="h-10 w-10 object-cover block" style="object-fit:cover;object-position:center;" onerror="this.style.display='none'; this.parentNode.innerHTML='<span class=\'inline-flex items-center justify-center h-10 w-10 rounded-full bg-[#23272a]\'><svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'#e2001a\' viewBox=\'0 0 24 24\' style=\'height:20px;width:20px;\'><circle cx=\'12\' cy=\'12\' r=\'10\' fill=\'#23272a\'/><path d=\'M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z\' fill=\'#e2001a\'/><circle cx=\'12\' cy=\'12\' r=\'3\' fill=\'#fff\'/></svg></span>'">
                    @else
                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-[#23272a]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#e2001a" viewBox="0 0 24 24" style="height:20px;width:20px;">
                                <circle cx="12" cy="12" r="10" fill="#23272a"/>
                                <path d="M12 4a8 8 0 0 1 8 8c0 2.5-1.5 4.5-4 6.5-2.5-2-4-4-4-6.5a8 8 0 0 1 8-8z" fill="#e2001a"/>
                                <circle cx="12" cy="12" r="3" fill="#fff"/>
                            </svg>
                        </span>
                    @endif
                </span>
            </td>
            <td class="py-2 px-4 font-semibold">
                {{ $equipe->nom }}
                @if(is_null($equipe->pool_id))
                    <span class="ml-2 px-2 py-1 rounded text-xs font-bold bg-yellow-300 text-yellow-900 align-middle">LIBRE</span>
                @endif
            </td>
            <td class="py-2 px-4">
                {{ $equipe->pool->nom ?? (is_null($equipe->pool_id) ? 'Libre' : '-') }}
            </td>
            <td class="py-2 px-4">{{ $equipe->coach }}</td>
        </tr>
    @endforeach
@endif
