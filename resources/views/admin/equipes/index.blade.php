@extends('layouts.admin')

@section('title', 'Gestion des Équipes')

@section('header')
    Gestion des Équipes (Saison : {{ $saison?->nom ?? 'Aucune' }})
@endsection

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.equipes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">Ajouter une équipe</a>
    <div class="flex gap-2">
        <a href="{{ route('admin.equipes.export', request()->all()) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600 transition">Exporter Excel</a>
        <a href="{{ route('admin.equipes.exportPdf', request()->all()) }}" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition">Exporter PDF</a>
    </div>
</div>
<button onclick="window.history.back()" class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 transition">← Retour</button>
<form method="GET" action="{{ route('admin.equipes.index') }}" class="mb-4 flex flex-wrap gap-4 items-end bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
    <div>
        <label class="block font-semibold text-gray-700 dark:text-gray-200">Nom</label>
        <input type="text" name="nom" value="{{ request('nom') }}" class="form-input w-48 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
    </div>
    <div>
        <label class="block font-semibold text-gray-700 dark:text-gray-200">
            Pool
            <span title="Une équipe libre n'est rattachée à aucune poule et peut participer à des rencontres amicales ou externes."
                  class="ml-1 text-blue-500 cursor-help" style="font-size:1.1em;">&#9432;</span>
        </label>
        <select name="pool_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
            <option value="">Tous</option>
            <option value="libre" {{ request('pool_id') === 'libre' ? 'selected' : '' }}>Libre</option>
            @foreach($pools as $pool)
                <option value="{{ $pool->id }}" {{ request('pool_id') == $pool->id ? 'selected' : '' }}>{{ $pool->nom }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block font-semibold text-gray-700 dark:text-gray-200">Saison</label>
        <select name="saison_id" class="form-select w-40 rounded border-gray-300 dark:bg-gray-700 dark:text-white">
            <option value="">Actuelle</option>
            @foreach($saisons as $s)
                <option value="{{ $s->id }}" {{ request('saison_id') == $s->id ? 'selected' : '' }}>{{ $s->annee ?? $s->nom }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-900 transition">Rechercher</button>
</form>
<div class="mb-4 flex flex-wrap gap-4 items-end">
    <input type="text" id="search-equipes" placeholder="Recherche rapide..." class="form-input w-64 rounded border-gray-300 dark:bg-gray-700 dark:text-white" />
</div>
<table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow mt-4 table-fixed equipes-table">
    <thead class="bg-gray-100 dark:bg-gray-700">
        <tr>
            <th class="py-2 px-4 w-20 text-center">Logo</th>
            <th class="py-2 px-4 w-40 text-center">Nom</th>
            <th class="py-2 px-4 w-32 text-center">Pool</th>
            <th class="py-2 px-4 w-40 text-center">Coach</th>
        </tr>
    </thead>
    <tbody>
        @foreach($equipes as $equipe)
        <tr class="border-b border-gray-200 dark:border-gray-700 text-center align-middle hover:bg-blue-50 dark:hover:bg-blue-900 transition cursor-pointer" onclick="window.location='{{ route('admin.equipes.show', $equipe) }}'">
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
            <td class="py-2 px-4 font-semibold">{{ $equipe->nom }}</td>
            <td class="py-2 px-4">{{ $equipe->pool->nom ?? '-' }}</td>
            <td class="py-2 px-4">{{ $equipe->coach }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-6 flex justify-center">
    {{ $equipes->links() }}
</div>
@endsection

@section('scripts')
<script>
document.getElementById('search-equipes').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.equipes-table tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
    });
});
</script>
@endsection
