<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('user_id', auth()->id())->paginate(20);
        return view('user.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        // Formulario para crear campaña
        return view('user.campaigns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'money_page_url' => 'required|url',
            'money_page_action' => 'required',
            'safe_page_url' => 'nullable|url',
            'safe_page_action' => 'required',
            'filter_level' => 'required|in:off,low,medium,high,paranoid'
        ]);

        $campaign = Campaign::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'token' => Str::uuid()->toString(),
            'money_page_url' => $request->money_page_url,
            'money_page_action' => $request->money_page_action,
            'safe_page_url' => $request->safe_page_url,
            'safe_page_action' => $request->safe_page_action,
            'filter_level' => $request->filter_level,
            'mode' => 'filtering',
            'active' => true
        ]);

        // Crear campaign_filters por defecto vacías
        CampaignFilter::create(['campaign_id' => $campaign->id]);

        return redirect()->route('user.campaigns.index')->with('status', 'Campaña creada.');
    }

    public function edit(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);
        $filter = $campaign->filters;
        return view('user.campaigns.edit', compact('campaign', 'filter'));
    }

    public function update(Campaign $campaign, Request $request)
    {
        $this->authorizeCampaign($campaign);

        $request->validate([
            'name' => 'required',
            'money_page_url' => 'required|url',
            'money_page_action' => 'required',
            'safe_page_url' => 'nullable|url',
            'safe_page_action' => 'required',
            'filter_level' => 'required|in:off,low,medium,high,paranoid',
            // Aquí podríamos validar los arrays de countries, etc. según se agreguen
        ]);

        $campaign->update([
            'name' => $request->name,
            'money_page_url' => $request->money_page_url,
            'money_page_action' => $request->money_page_action,
            'safe_page_url' => $request->safe_page_url,
            'safe_page_action' => $request->safe_page_action,
            'filter_level' => $request->filter_level,
        ]);

        $filter = $campaign->filters;
        $filter->allowed_countries = $request->allowed_countries ?? [];
        $filter->allowed_os = $request->allowed_os ?? [];
        $filter->allowed_browsers = $request->allowed_browsers ?? [];
        $filter->blocked_ips = $request->blocked_ips ?? [];
        $filter->allowed_timezones = $request->allowed_timezones ?? [];
        $filter->block_no_language = $request->boolean('block_no_language');
        $filter->match_browser_tz = $request->boolean('match_browser_tz');
        $filter->required_utm = $request->required_utm ?? [];
        $filter->save();

        return redirect()->route('user.campaigns.index')->with('status', 'Campaña actualizada.');
    }

    public function destroy(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);
        $campaign->delete();
        return redirect()->route('user.campaigns.index')->with('status', 'Campaña eliminada.');
    }

    protected function authorizeCampaign(Campaign $campaign)
    {
        if ($campaign->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
