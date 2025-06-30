<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date naissance</th>
            <th>Poste</th>
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
        </tr>
    @endforeach
    </tbody>
</table>
