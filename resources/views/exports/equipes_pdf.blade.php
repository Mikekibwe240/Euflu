<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Équipes</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #888; padding: 6px 8px; text-align: center; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Liste des Équipes</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Pool</th>
                <th>Coach</th>
                <th>Saison</th>
            </tr>
        </thead>
        <tbody>
        @foreach($equipes as $equipe)
            <tr>
                <td>{{ $equipe->nom }}</td>
                <td>{{ $equipe->pool->nom ?? '-' }}</td>
                <td>{{ $equipe->coach }}</td>
                <td>{{ $equipe->saison->nom ?? ($equipe->saison->annee ?? '-') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
