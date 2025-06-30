<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Rencontres</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #888; padding: 6px 8px; text-align: center; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Liste des Rencontres</h2>
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
                <td>{{ $r->mvp->nom ?? $r->mvp_libre ?? '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
