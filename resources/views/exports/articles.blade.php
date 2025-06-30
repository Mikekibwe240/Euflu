<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Saison</th>
            <th>Date</th>
            <th>Auteur</th>
            <th>Modifié par</th>
        </tr>
    </thead>
    <tbody>
    @foreach($articles as $article)
        <tr>
            <td>{{ $article->titre }}</td>
            <td>{{ $article->saison->annee ?? '-' }}</td>
            <td>{{ $article->created_at }}</td>
            <td>{{ $article->user->name ?? '-' }}</td>
            <td>{{ $article->updated_by ? $article->updatedBy->name : '-' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
