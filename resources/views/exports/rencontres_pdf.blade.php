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
                <th>Dernière modification</th>
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
                <td>{{ $r->updated_at ? \Carbon\Carbon::parse($r->updated_at)->format('d/m/Y à H:i') : '-' }}</td>
            </tr>
            <tr>
                <td colspan="9" style="padding:0;">
                    <table style="width:100%;border:none;font-size:11px;">
                        <tr>
                            <td style="width:50%;vertical-align:top;padding:4px;">
                                <strong>Effectif {{ $r->equipe1->nom ?? $r->equipe1_libre }} :</strong><br>
                                @php
                                    $eff1 = $r->matchEffectifs->where('equipe_id', $r->equipe1->id ?? null)->first();
                                @endphp
                                <span style="color:#1a237e;">Titulaires :</span>
                                @if($eff1 && $eff1->joueurs->where('type','titulaire')->count())
                                    <ul style="margin:2px 0 6px 12px;padding:0;">
                                    @foreach($eff1->joueurs->where('type','titulaire')->sortBy('ordre') as $tit)
                                        <li>{{ $tit->joueur->nom ?? '-' }} <span style="color:#888;">(#{{ $tit->joueur->numero_dossard ?? '-' }})</span></li>
                                    @endforeach
                                    </ul>
                                @else
                                    <span style="color:#888;">Aucun titulaire</span><br>
                                @endif
                                <span style="color:#e65100;">Remplaçants :</span>
                                @if($eff1 && $eff1->joueurs->filter(function($j){ return in_array($j->type, ['remplaçant','remplacant']); })->count())
                                    <ul style="margin:2px 0 0 12px;padding:0;">
                                    @foreach($eff1->joueurs->filter(function($j){ return in_array($j->type, ['remplaçant','remplacant']); })->sortBy('ordre') as $remp)
                                        <li>{{ $remp->joueur->nom ?? '-' }} <span style="color:#888;">(#{{ $remp->joueur->numero_dossard ?? '-' }})</span></li>
                                    @endforeach
                                    </ul>
                                @else
                                    <span style="color:#888;">Aucun remplaçant</span>
                                @endif
                            </td>
                            <td style="width:50%;vertical-align:top;padding:4px;">
                                <strong>Effectif {{ $r->equipe2->nom ?? $r->equipe2_libre }} :</strong><br>
                                @php
                                    $eff2 = $r->matchEffectifs->where('equipe_id', $r->equipe2->id ?? null)->first();
                                @endphp
                                <span style="color:#1a237e;">Titulaires :</span>
                                @if($eff2 && $eff2->joueurs->where('type','titulaire')->count())
                                    <ul style="margin:2px 0 6px 12px;padding:0;">
                                    @foreach($eff2->joueurs->where('type','titulaire')->sortBy('ordre') as $tit)
                                        <li>{{ $tit->joueur->nom ?? '-' }} <span style="color:#888;">(#{{ $tit->joueur->numero_dossard ?? '-' }})</span></li>
                                    @endforeach
                                    </ul>
                                @else
                                    <span style="color:#888;">Aucun titulaire</span><br>
                                @endif
                                <span style="color:#e65100;">Remplaçants :</span>
                                @if($eff2 && $eff2->joueurs->filter(function($j){ return in_array($j->type, ['remplaçant','remplacant']); })->count())
                                    <ul style="margin:2px 0 0 12px;padding:0;">
                                    @foreach($eff2->joueurs->filter(function($j){ return in_array($j->type, ['remplaçant','remplacant']); })->sortBy('ordre') as $remp)
                                        <li>{{ $remp->joueur->nom ?? '-' }} <span style="color:#888;">(#{{ $remp->joueur->numero_dossard ?? '-' }})</span></li>
                                    @endforeach
                                    </ul>
                                @else
                                    <span style="color:#888;">Aucun remplaçant</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
