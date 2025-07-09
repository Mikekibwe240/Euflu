<table>
    <thead>
        <tr>
            <th>#</th>
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
    @foreach($joueurs as $i => $joueur)
        <tr>
            <td>{{ $i + 1 }}</td>
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
