<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignStat;
use Illuminate\Support\Facades\DB;
use PHPUnit\Event\Runtime\PHP;

class CampaignController extends Controller
{
    /**
     * Display list of campaigns and aggregate revenue for each campaign
     */
    public function index()
    {

        //base query
        $allQuery = CampaignStat::query()
            ->select('campaign_id', 'utm_term_id', 'revenue as total_revenue')
            ->groupBy('campaign_id')
            ->with('campaign');

        // Get total revenue across all campaigns
        $totalRevenue = $allQuery->get()->sum('total_revenue');


        // Paginate and format revenue
        $allCampaignStat = $allQuery->paginate(10)
            ->through(function ($item) {
                $item->total_revenue = number_format($item->total_revenue, config('app.decimel_digit'), '.', '');
                return $item;
            });

        //$this->my_dd($allCampaignStat);


        return view('campaign.index', compact('allCampaignStat', 'totalRevenue'));
    }

    /**
     * Display a specific campaign with a hourly breakdown of all revenue
     */
    public function show(Campaign $campaign, $type = null)
    {

        // Start by preparing the common part of the query
        $query = CampaignStat::where('campaign_id', $campaign->id)
            ->with('utmTerm');

        // Check the database driver (SQLite vs other)
        if (DB::getDriverName() === 'sqlite') {
            // SQLite-specific query formatting
            $query->selectRaw('strftime("%Y-%m-%d %H:00:00", monetization_timestamp) as hour, SUM(revenue) as total_revenue, utm_term_id');

            if ($type == 'utm') {
                $query->groupBy('utm_term_id')
                    ->groupBy(DB::raw('strftime("%Y-%m-%d %H:00:00", monetization_timestamp)'));
            } else {
                $query->groupBy(DB::raw('strftime("%Y-%m-%d %H:00:00", monetization_timestamp)'));
            }
        } else {
            // MySQL/PostgreSQL-specific query formatting
            $query->selectRaw('DATE_FORMAT(monetization_timestamp, "%Y-%m-%d %H:00:00") as hour, SUM(revenue) as total_revenue, utm_term_id');

            if (request()->has('utm')) {
                $query->groupBy('utm_term_id')
                    ->groupBy(DB::raw('DATE_FORMAT(monetization_timestamp, "%Y-%m-%d %H:00:00")'));
            } else {
                $query->groupBy(DB::raw('DATE_FORMAT(monetization_timestamp, "%Y-%m-%d %H:00:00")'));
            }
        }

        $totalRevenue = $query->get()->sum('total_revenue');
        // Finalize the query (common code for both DB types)
        $hourlyRevenue = $query
            ->orderBy('hour', 'asc')
            ->paginate(10)
            ->through(function ($item) {
                $item->total_revenue = number_format($item->total_revenue, config('app.decimel_digit'), '.', '');
                return $item;
            });

        //$totalRevenue = $query->get()->sum('total_revenue');

        return view('campaign.hourly_revenue', compact('campaign', 'hourlyRevenue', 'totalRevenue'));
    }

    /**
     * Display a specific campaign with the aggregate revenue by utm_term
     */
    public function publishers(Campaign $campaign)
    {
        // @TODO implement
    }

    public function my_dd($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}
