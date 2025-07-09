<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Joueurs</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #888; padding: 6px 8px; text-align: center; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Liste des Joueurs par Équipe</h2>
    @php
        $groupes = $joueurs->groupBy(function($j) {
            return $j->equipe ? $j->equipe->nom : 'Sans équipe';
        });
    @endphp
    @foreach($groupes as $equipeNom => $joueursEquipe)
        <h3 style="margin-top:30px;">Équipe : {{ $equipeNom }}</h3>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date naissance</th>
                    <th>Poste</th>
                    <th>Licence</th>
                    <th>Dossard</th>
                    <th>Nationalité</th>
                </tr>
            </thead>
            <tbody>
            @foreach($joueursEquipe as $joueur)
                <tr>
                    <td>{{ $joueur->nom }}</td>
                    <td>{{ $joueur->prenom }}</td>
                    <td>{{ $joueur->date_naissance }}</td>
                    <td>{{ $joueur->poste }}</td>
                    <td>{{ $joueur->numero_licence ?? '-' }}</td>
                    <td>{{ $joueur->numero_dossard ?? '-' }}</td>
                    <td>{{ $joueur->nationalite ?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
