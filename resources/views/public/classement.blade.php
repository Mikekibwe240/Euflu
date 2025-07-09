@extends('layouts.public')
@section('title', 'Classement EUFLU')
@section('content')
<div class="max-w-6xl mx-auto mt-10 mb-8">
    @php
        use App\Helpers\SaisonHelper;
        // Closure pour générer une abréviation d'équipe (ex: "Paris Saint-Germain" => "PSG")
        $makeAbbreviation = function($name) {
            $words = preg_split('/\s+/', trim($name));
            if (count($words) === 1) {
                return mb_strtoupper(mb_substr($name, 0, 3));
            }
            $abbr = '';
            foreach ($words as $w) {
                if (mb_strlen($w) > 0 && preg_match('/[A-Za-zÀ-ÿ]/u', $w)) {
                    $abbr .= mb_strtoupper(mb_substr($w, 0, 1));
                }
            }
            return $abbr;
        };
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        $saison = SaisonHelper::getActiveSaison();
        $selectedSaison = request('saison_id') ? \App\Models\Saison::find(request('saison_id')) : ($saison ?? null);
        $pools = $selectedSaison ? $selectedSaison->pools()->with(['equipes', 'equipes.statsSaison'])->get() : collect();
        $selectedPool = request('pool');
    @endphp
    <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-8 gap-4">
        <div>
            <div class="text-4xl font-extrabold text-white uppercase tracking-wider mb-2">CLASSEMENT</div>
            <div class="text-base text-gray-400 font-semibold uppercase">Tableau complet</div>
        </div>
        <form method="GET" action="" class="flex items-center gap-4 px-4 py-3 rounded-lg bg-[#181d1f] border border-[#31363a] shadow-md">
            <label for="saison_id" class="text-gray-200 font-bold uppercase tracking-wide mr-2">Saison</label>
            <select name="saison_id" id="saison_id" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] focus:outline-none focus:ring-2 focus:ring-[#e2001a] font-semibold shadow-sm transition placeholder-gray-400">
                @foreach($saisons as $s)
                    <option value="{{ $s->id }}" @if(request('saison_id', $saison?->id) == $s->id) selected @endif style="color:#23272a; background:#fff; font-weight:bold;">{{ $s->nom }}</option>
                @endforeach
            </select>
            <label for="pool" class="text-gray-200 font-bold uppercase tracking-wide ml-4">Pool</label>
            <select name="pool" id="pool" class="bg-transparent text-[#6fcf97] px-4 py-2 rounded border-2 border-[#6fcf97] focus:outline-none focus:ring-2 focus:ring-[#e2001a] font-semibold shadow-sm transition placeholder-gray-400">
                <option value="">Tous</option>
                @foreach($pools as $p)
                    <option value="{{ $p->nom }}" @if(request('pool', $selectedPool) == $p->nom) selected @endif style="color:#23272a; background:#fff; font-weight:bold;">{{ $p->nom }}</option>
                @endforeach
            </select>
            <button type="submit" class="ml-2 px-5 py-2 bg-gradient-to-r from-[#e2001a] to-[#b80016] text-white font-extrabold rounded shadow-lg hover:from-[#b80016] hover:to-[#e2001a] focus:outline-none focus:ring-2 focus:ring-[#6fcf97] transition">OK</button>
        </form>
    </div>
    @if($selectedSaison && $pools->count())
        @foreach($pools as $pool)
            @if(!$selectedPool || $selectedPool == $pool->nom)
            <div class="mb-8" @if($selectedPool && $selectedPool == $pool->nom) id="selected-pool" @endif>
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-[#e2001a] font-extrabold text-lg uppercase tracking-wider">Classement</span>
                    <span class="text-gray-400 font-bold uppercase text-xs">{{ $pool->nom }}</span>
                </div>
                <div class="overflow-x-auto rounded-lg shadow" style="background:#181d1f;">
                    <table class="min-w-full bg-[#23272a] text-white text-base bundesliga-table" style="border-radius:0;">
                        <thead class="bg-transparent text-white uppercase text-base">
                            <tr>
                                <th class="px-4 py-3 text-left font-extrabold" style="font-size:2rem;">PL</th>
                                <th class="px-4 py-3 text-left font-extrabold" style="font-size:2rem;">EQUIPES</th>
                                <th class="px-4 py-3 text-center font-extrabold">MJ</th>
                                <th class="px-4 py-3 text-center font-extrabold">MG</th>
                                <th class="px-4 py-3 text-center font-extrabold">MP</th>
                                <th class="px-4 py-3 text-center font-extrabold">MN</th>
                                <th class="px-4 py-3 text-center font-extrabold">BP</th>
                                <th class="px-4 py-3 text-center font-extrabold">BC</th>
                                <th class="px-4 py-3 text-center font-extrabold">GD</th>
                                <th class="px-4 py-3 text-center font-extrabold">PTS</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $classement = $pool->equipes->map(function($eq) use ($selectedSaison) {
                                $stats = $eq->statsSaison($selectedSaison->id)->first();
                                return (object) [
                                    'equipe' => $eq,
                                    'mj' => ($stats?->victoires ?? 0) + ($stats?->nuls ?? 0) + ($stats?->defaites ?? 0),
                                    'mg' => $stats?->victoires ?? 0,
                                    'mp' => $stats?->defaites ?? 0,
                                    'mn' => $stats?->nuls ?? 0,
                                    'bp' => $stats?->buts_pour ?? 0,
                                    'bc' => $stats?->buts_contre ?? 0,
                                    'gd' => ($stats?->buts_pour ?? 0) - ($stats?->buts_contre ?? 0),
                                    'points' => $stats?->points ?? 0,
                                ];
                            })->sortByDesc('points')->sortByDesc('gd')->sortByDesc('bp')->values();
                        @endphp
                        @foreach($classement as $i => $row)
                            <tr class="border-b border-[#333] hover:bg-[#e2001a]/10 transition cursor-pointer" style="font-size:1.15rem;" onclick="window.location='{{ route('equipes.show', $row->equipe->id) }}'">
                                <td class="px-4 py-3 font-extrabold text-white">{{ $i+1 }}</td>
                                <td class="px-4 py-3 flex items-center gap-2 font-extrabold">
                                    <x-team-logo :team="$row->equipe" :size="32" />
                                    <span>{{ $row->equipe->nom }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">{{ $row->mj }}</td>
                                <td class="px-4 py-3 text-center">{{ $row->mg }}</td>
                                <td class="px-4 py-3 text-center">{{ $row->mp }}</td>
                                <td class="px-4 py-3 text-center">{{ $row->mn }}</td>
                                <td class="px-4 py-3 text-center">{{ $row->bp }}</td>
                                <td class="px-4 py-3 text-center">{{ $row->bc }}</td>
                                <td class="px-4 py-3 text-center">{{ $row->gd }}</td>
                                <td class="px-4 py-3 text-center font-extrabold text-white">{{ $row->points }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        @endforeach
        <div class="flex justify-center gap-4 mt-8">
            <a href="?pool={{ $pools->first()->nom }}" class="px-6 py-3 rounded-lg font-bold text-lg bg-gradient-to-r from-[#6fcf97] to-[#23272a] text-white shadow-lg border-2 border-[#6fcf97] hover:from-[#23272a] hover:to-[#6fcf97] transition">Précédent</a>
            <a href="?pool={{ $pools->last()->nom }}" class="px-6 py-3 rounded-lg font-bold text-lg bg-gradient-to-r from-[#e2001a] to-[#b80016] text-white shadow-lg border-2 border-[#e2001a] hover:from-[#b80016] hover:to-[#e2001a] transition">Suivant</a>
        </div>
        @if($selectedPool)
        <script>
            // Scroll to the selected pool if present
            window.onload = function() {
                var el = document.getElementById('selected-pool');
                if(el) el.scrollIntoView({behavior: 'smooth', block: 'start'});
            };
        </script>
        @endif
    @endif
</div>
@endsection
