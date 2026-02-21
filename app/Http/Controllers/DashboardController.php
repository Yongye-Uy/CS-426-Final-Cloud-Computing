<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get recent donations with related data (both completed and pending for admin visibility)
        $recentDonations = Donation::with(['campaign', 'donor'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get recent completed donations only
        $recentCompletedDonations = Donation::with(['campaign', 'donor'])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get all users with role information for user management
        $users = User::with('role')->latest()->get();

        // Get campaigns with statistics (only completed donations)
        $campaigns = Campaign::with(['user', 'donations' => function($query) {
                $query->where('status', 'completed');
            }])
            ->withCount(['donations as completed_donations_count' => function($query) {
                $query->where('status', 'completed');
            }])
            ->withSum(['donations as completed_donations_sum' => function($query) {
                $query->where('status', 'completed');
            }], 'amount')
            ->latest()
            ->get();

        // Get top donors (only completed donations)
        $topDonors = User::select('users.id', 'users.name', 'users.email', 'users.organization', DB::raw('SUM(donations.amount) as total_donated'))
            ->join('donations', 'users.id', '=', 'donations.donor_id')
            ->where('donations.status', 'completed')
            ->groupBy('users.id', 'users.name', 'users.email', 'users.organization')
            ->orderBy('total_donated', 'desc')
            ->take(10)
            ->get();

        // Calculate dashboard statistics
        $stats = [
            'total_donations' => Donation::where('status', 'completed')->sum('amount'),
            'pending_donations' => Donation::where('status', 'pending')->sum('amount'),
            'pending_donations_count' => Donation::where('status', 'pending')->count(),
            'total_campaigns' => Campaign::count(),
            'active_campaigns' => Campaign::where('status', 'active')->count(),
            'total_users' => User::count(),
            'pending_campaigns' => Campaign::where('approval_status', 'pending')->count(),
            'approved_campaigns' => Campaign::where('approval_status', 'approved')->count(),
        ];

        return view('dashboard', compact(
            'recentDonations',
            'recentCompletedDonations',
            'users', 
            'campaigns',
            'topDonors',
            'stats'
        ));
    }
}
