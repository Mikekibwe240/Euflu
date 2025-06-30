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
            <td>{{ $equipe->saison->nom ?? '-' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
