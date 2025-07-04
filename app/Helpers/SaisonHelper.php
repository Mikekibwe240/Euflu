<?php
namespace App\Helpers;

use App\Models\Saison;
use Illuminate\Http\Request;

class SaisonHelper
{
    /**
     * Retourne la saison à utiliser (filtrée, active, ou fallback)
     */
    public static function getActiveSaison(Request $request = null)
    {
        $request = $request ?? request();
        if ($request->filled('saison_id')) {
            $saison = Saison::find($request->input('saison_id'));
            if ($saison) return $saison;
        }
        // Toujours prioriser la saison active (active = 1)
        $saison = Saison::where('active', 1)->first();
        if ($saison) return $saison;
        // Si aucune saison active, fallback sur la plus récente
        return Saison::orderByDesc('date_debut')->first();
    }
}
