<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Campaign;
use App\Models\Testimonial;
use App\Models\Donor;

class HomeController extends Controller
{
    public function index()
    {
        // Get statistics for the hero section
        $totalDonations = Donation::where('status', 'completed')->sum('amount');
        $totalDonors = Donor::where('is_active', true)->count();
        $activeCampaigns = Campaign::where('status', 'active')->count();
        
        // Get campaign progress data
        $featuredCampaign = Campaign::where('status', 'active')->first();
        $campaignProgress = $featuredCampaign ? $featuredCampaign->progress_percentage : 0;
        
        // Get recent donations for dashboard preview
        $recentDonations = Donation::with(['donor', 'campaign'])
            ->where('status', 'completed')
            ->orderBy('donation_date', 'desc')
            ->take(3)
            ->get();
        
        // Get testimonials
        $testimonials = Testimonial::active()
            ->featured()
            ->take(3)
            ->get();
        
        // Get featured campaigns for home page
        $featuredCampaigns = Campaign::getFeaturedCampaigns(4);
        
        return view('home', compact(
            'totalDonations',
            'totalDonors', 
            'activeCampaigns',
            'featuredCampaign',
            'campaignProgress',
            'recentDonations',
            'testimonials',
            'featuredCampaigns'
        ));
    }

    public function isLoggedIn()
    {
        return auth()->check();
    }
}
