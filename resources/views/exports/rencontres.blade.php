@php use Carbon\Carbon; @endphp
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Heure</th>
            <th>Pool</th>
            <th>Équipe 1</th>
            <th>Équipe 2</th>
            <th>Score</th>
            <th>Stade</th>
            <th>MVP</th>
        </tr>
    </thead>
    <tbody>
    @foreach($rencontres as $r)
        <tr>
            <td>{{ $r->date }}</td>
            <td>{{ $r->heure }}</td>
            <td>{{ $r->pool->nom ?? '-' }}</td>
            <td>{{ $r->equipe1->nom ?? $r->equipe1_libre }}</td>
            <td>{{ $r->equipe2->nom ?? $r->equipe2_libre }}</td>
            <td>@if(!is_null($r->score_equipe1) && !is_null($r->score_equipe2)) {{ $r->score_equipe1 }} - {{ $r->score_equipe2 }} @else - @endif</td>
            <td>{{ $r->stade }}</td>
            <td>{{ $r->mvp && $r->mvp->joueur ? $r->mvp->nom : '-' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
