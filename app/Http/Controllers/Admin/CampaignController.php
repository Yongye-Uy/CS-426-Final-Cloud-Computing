<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    // Middleware is applied in routes/web.php, no need for constructor middleware

    /**
     * Display all campaigns for admin management
     */
    public function index()
    {
        $campaigns = Campaign::with(['creator', 'approver'])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_campaigns' => Campaign::count(),
            'pending_campaigns' => Campaign::pending()->count(),
            'approved_campaigns' => Campaign::approved()->count(),
            'rejected_campaigns' => Campaign::rejected()->count(),
        ];

        return view('admin.campaigns.index', compact('campaigns', 'stats'));
    }

    /**
     * Show campaign details for admin review
     */
    public function show(Campaign $campaign)
    {
        $campaign->load(['creator', 'approver', 'donations.donor']);
        
        return view('admin.campaigns.show', compact('campaign'));
    }

    /**
     * Approve a campaign
     */
    public function approve(Campaign $campaign)
    {
        $campaign->approve(auth()->id());

        return redirect()->route('admin.campaigns.index')
            ->with('success', "Campaign '{$campaign->name}' has been approved successfully!");
    }

    /**
     * Show rejection form
     */
    public function rejectForm(Campaign $campaign)
    {
        return view('admin.campaigns.reject', compact('campaign'));
    }

    /**
     * Reject a campaign
     */
    public function reject(Request $request, Campaign $campaign)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10'
        ]);

        $campaign->reject(auth()->id(), $request->rejection_reason);

        return redirect()->route('admin.campaigns.index')
            ->with('success', "Campaign '{$campaign->name}' has been rejected.");
    }

    /**
     * Update campaign status
     */
    public function updateStatus(Request $request, Campaign $campaign)
    {
        $request->validate([
            'status' => 'required|in:active,paused,completed,cancelled'
        ]);

        $campaign->update(['status' => $request->status]);

        return redirect()->route('admin.campaigns.index')
            ->with('success', "Campaign status updated to '{$request->status}'.");
    }

    /**
     * Delete a campaign
     */
    public function destroy(Campaign $campaign)
    {
        $campaignName = $campaign->name;
        $campaign->delete();

        return redirect()->route('admin.campaigns.index')
            ->with('success', "Campaign '{$campaignName}' has been deleted.");
    }

    /**
     * Bulk actions for campaigns
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'campaigns' => 'required|array',
            'campaigns.*' => 'exists:campaigns,id'
        ]);

        $campaigns = Campaign::whereIn('id', $request->campaigns)->get();
        $count = $campaigns->count();

        switch ($request->action) {
            case 'approve':
                foreach ($campaigns as $campaign) {
                    $campaign->approve(auth()->id());
                }
                $message = "{$count} campaigns approved successfully!";
                break;

            case 'reject':
                foreach ($campaigns as $campaign) {
                    $campaign->reject(auth()->id(), 'Bulk rejection by admin');
                }
                $message = "{$count} campaigns rejected.";
                break;

            case 'delete':
                Campaign::whereIn('id', $request->campaigns)->delete();
                $message = "{$count} campaigns deleted.";
                break;
        }

        return redirect()->route('admin.campaigns.index')->with('success', $message);
    }
}
