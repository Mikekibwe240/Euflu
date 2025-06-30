<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date naissance</th>
            <th>Poste</th>
            <th>Équipe</th>
        </tr>
    </thead>
    <tbody>
    @foreach($joueurs as $joueur)
        <tr>
            <td>{{ $joueur->id }}</td>
            <td>{{ $joueur->nom }}</td>
            <td>{{ $joueur->prenom }}</td>
            <td>{{ $joueur->date_naissance }}</td>
            <td>{{ $joueur->poste }}</td>
            <td>{{ $joueur->equipe->nom ?? '-' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
