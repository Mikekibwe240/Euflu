<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Feuille de match</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        .header { text-align: center; font-weight: bold; font-size: 20px; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .table th, .table td { border: 1px solid #333; padding: 5px; text-align: left; }
        .table th { background: #eee; }
    </style>
</head>
<body>
    <div class="header">Feuille de match</div>
    <div class="section">
        <strong>Match :</strong> {{ $rencontre->equipe1->nom }} vs {{ $rencontre->equipe2->nom }}<br>
        <strong>Date :</strong> {{ $rencontre->date }}<br>
        <strong>Heure :</strong> {{ $rencontre->heure }}<br>
        <strong>Stade :</strong> {{ $rencontre->stade }}<br>
        <strong>Journée :</strong> {{ $rencontre->journee }}<br>
        <strong>Pool :</strong> {{ $rencontre->pool?->nom ?? '-' }}<br>
    </div>
    <div class="section">
        <strong>Score :</strong> {{ $rencontre->score_equipe1 ?? '-' }} - {{ $rencontre->score_equipe2 ?? '-' }}
    </div>
    <div class="section">
        <strong>Buteurs :</strong>
        <ul>
            @forelse($rencontre->buts as $but)
                <li>{{ $but->joueur?->nom }} {{ $but->joueur?->prenom }} ({{ $but->minute }}') - {{ $but->equipe_id == $rencontre->equipe1?->id ? $rencontre->equipe1?->nom : $rencontre->equipe2?->nom }}</li>
            @empty
                <li>Aucun</li>
            @endforelse
        </ul>
    </div>
    <div class="section">
        <strong>Cartons :</strong>
        <ul>
            @forelse($rencontre->cartons as $carton)
                <li>{{ $carton->joueur?->nom }} {{ $carton->joueur?->prenom }} ({{ $carton->minute }}') - {{ ucfirst($carton->type) }}</li>
            @empty
                <li>Aucun</li>
            @endforelse
        </ul>
    </div>
    <div class="section">
        <strong>Homme du match :</strong> {{ $rencontre->mvp?->nom ?? '-' }}
    </div>
</body>
</html>
