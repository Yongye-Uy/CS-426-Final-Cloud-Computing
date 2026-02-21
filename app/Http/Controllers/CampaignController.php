<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Donation;

class CampaignController extends Controller
{
    /**
     * Display a listing of campaigns for public view
     */
    public function index()
    {
        $campaigns = Campaign::where('status', 'active')
            ->where('approval_status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_campaigns' => Campaign::approved()->count(),
            'active_campaigns' => Campaign::where('status', 'active')->where('approval_status', 'approved')->count(),
            'total_raised' => Campaign::approved()->sum('raised_amount'),
            'total_goal' => Campaign::approved()->sum('goal_amount'),
        ];

        return view('campaigns.index', compact('campaigns', 'stats'));
    }

    /**
     * Display the specified campaign details
     */
    public function show(Campaign $campaign)
    {
        // Only show approved campaigns to public
        if (!$campaign->isApproved() && !auth()->user()?->isAdmin()) {
            abort(404);
        }

        $campaign->load(['donations.donor', 'creator']);
        
        $recentDonations = $campaign->donations()
            ->with('donor')
            ->latest()
            ->take(10)
            ->get();

        return view('campaigns.show', compact('campaign', 'recentDonations'));
    }

    /**
     * Show user's campaigns
     */
    public function myCampaigns()
    {
        $campaigns = Campaign::where('created_by', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('campaigns.my-campaigns', compact('campaigns'));
    }

    /**
     * Show the form for creating a new campaign
     */
    public function create()
    {
        return view('campaigns.create');
    }

    /**
     * Store a newly created campaign
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'goal_amount' => 'required|numeric|min:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'video_url' => 'nullable|url',
            'image_url' => 'nullable|url',
        ]);

        $campaign = Campaign::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'goal_amount' => $validated['goal_amount'],
            'raised_amount' => 0,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'video_url' => $validated['video_url'],
            'image_url' => $validated['image_url'],
            'status' => 'paused',
            'approval_status' => 'pending',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('campaigns.my-campaigns')
            ->with('success', 'Campaign created successfully! It will be reviewed by our team and activated once approved.');
    }

    /**
     * Show the form for editing the specified campaign
     */
    public function edit(Campaign $campaign)
    {
        // Only allow creator or admin to edit
        if ($campaign->created_by !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified campaign
     */
    public function update(Request $request, Campaign $campaign)
    {
        // Only allow creator or admin to update
        if ($campaign->created_by !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'goal_amount' => 'required|numeric|min:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'video_url' => 'nullable|url',
            'image_url' => 'nullable|url',
        ]);

        // If campaign was rejected and user is updating, reset to pending
        if ($campaign->isRejected() && $campaign->created_by === auth()->id()) {
            $validated['approval_status'] = 'pending';
            $validated['rejection_reason'] = null;
        }

        $campaign->update($validated);

        return redirect()->route('campaigns.my-campaigns')
            ->with('success', 'Campaign updated successfully!');
    }

    /**
     * Remove the specified campaign
     */
    public function destroy(Campaign $campaign)
    {
        // Only allow creator or admin to delete
        if ($campaign->created_by !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $campaign->delete();

        return redirect()->route('campaigns.my-campaigns')
            ->with('success', 'Campaign deleted successfully!');
    }
}
