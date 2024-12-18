<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Campaign;

class StatsController extends Controller
{
    public function index(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);
        // Aquí recuperamos logs, conteos, gráficos.
        // Por ahora, datos mínimos.
        $logsCount = $campaign->logs()->count();
        $filteredCount = $campaign->logs()->where('is_filtered', true)->count();

        return view('user.campaigns.stats', compact('campaign','logsCount','filteredCount'));
    }

    protected function authorizeCampaign(Campaign $campaign)
    {
        if ($campaign->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
