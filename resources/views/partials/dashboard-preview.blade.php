<!-- Modern Dashboard Preview Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="pe-lg-4">
                    <span class="badge bg-primary-light text-primary px-3 py-2 mb-3">Dashboard Preview</span>
                    <h2 class="display-5 fw-bold mb-4">Real-Time Donation Insights at Your Fingertips</h2>
                    <p class="lead text-muted mb-4">Transform how you manage donations with our intelligent dashboard that provides actionable insights and streamlined workflows.</p>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="feature-icon-small bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-bold mb-1">Live Analytics</h6>
                                    <p class="text-muted mb-0 small">Real-time donation tracking with advanced filtering and reporting capabilities.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="feature-icon-small bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-bold mb-1">Smart Alerts</h6>
                                    <p class="text-muted mb-0 small">Automated notifications for important events and milestones.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="feature-icon-small bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-bold mb-1">Donor Management</h6>
                                    <p class="text-muted mb-0 small">Comprehensive donor profiles with engagement history.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="feature-icon-small bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-bold mb-1">Secure & Compliant</h6>
                                    <p class="text-muted mb-0 small">Bank-level security with full compliance standards.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-rocket me-2"></i>Start Free Trial
                        </a>
                        <a href="{{ route('campaigns.index') }}" class="btn btn-outline-primary btn-lg px-4">
                            <i class="fas fa-eye me-2"></i>View Campaigns
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="position-relative">
                    <!-- Main Dashboard Card -->
                    <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                        <!-- Header -->
                        <div class="card-header bg-gradient-primary text-white border-0 p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1 fw-bold">
                                        <i class="fas fa-chart-bar me-2"></i>Donation Analytics
                                    </h5>
                                    <p class="mb-0 opacity-75">Real-time insights and performance metrics</p>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-calendar me-1"></i>This Month
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-clock me-2"></i>Today</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-week me-2"></i>This Week</a></li>
                                        <li><a class="dropdown-item active" href="#"><i class="fas fa-calendar-alt me-2"></i>This Month</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2"></i>This Year</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Stats Grid -->
                        <div class="card-body p-4">
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="stat-card-modern bg-gradient-success text-white p-4 rounded-3 h-100">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <p class="mb-1 opacity-75">Total Raised</p>
                                                <h3 class="mb-1 fw-bold">${{ number_format($totalDonations ?? 125420, 0) }}</h3>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-arrow-up me-1"></i>
                                                    <span class="small">+12.5% vs last month</span>
                                                </div>
                                            </div>
                                            <div class="stat-icon bg-white bg-opacity-20 rounded-circle p-3">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-card-modern bg-gradient-primary text-white p-4 rounded-3 h-100">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <p class="mb-1 opacity-75">Active Donors</p>
                                                <h3 class="mb-1 fw-bold">{{ $totalDonors ?? 1247 }}</h3>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-arrow-up me-1"></i>
                                                    <span class="small">+8.2% vs last month</span>
                                                </div>
                                            </div>
                                            <div class="stat-icon bg-white bg-opacity-20 rounded-circle p-3">
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-card-modern bg-gradient-warning text-white p-4 rounded-3 h-100">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <p class="mb-1 opacity-75">Campaigns</p>
                                                <h3 class="mb-1 fw-bold">{{ $activeCampaigns ?? 24 }}</h3>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-clock me-1"></i>
                                                    <span class="small">5 ending soon</span>
                                                </div>
                                            </div>
                                            <div class="stat-icon bg-white bg-opacity-20 rounded-circle p-3">
                                                <i class="fas fa-bullseye"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-card-modern bg-gradient-info text-white p-4 rounded-3 h-100">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <p class="mb-1 opacity-75">Avg. Donation</p>
                                                <h3 class="mb-1 fw-bold">${{ number_format(($totalDonations ?? 125420) / max(($totalDonors ?? 1247), 1), 0) }}</h3>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-arrow-up me-1"></i>
                                                    <span class="small">+15.3% vs last month</span>
                                                </div>
                                            </div>
                                            <div class="stat-icon bg-white bg-opacity-20 rounded-circle p-3">
                                                <i class="fas fa-chart-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Featured Campaign Progress -->
                            @if($featuredCampaign ?? null)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">
                                        <i class="fas fa-star text-warning me-2"></i>Featured Campaign
                                    </h6>
                                    <span class="badge bg-primary">{{ $campaignProgress ?? 0 }}% Complete</span>
                                </div>
                                <div class="campaign-progress-card bg-light p-3 rounded-3">
                                    <h6 class="fw-bold mb-2">{{ Str::limit($featuredCampaign->name ?? 'Clean Water Initiative', 40) }}</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-success fw-bold">${{ number_format($featuredCampaign->raised_amount ?? 45230, 0) }} raised</span>
                                        <span class="text-muted">of ${{ number_format($featuredCampaign->goal_amount ?? 75000, 0) }} goal</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-gradient-success" role="progressbar" 
                                             style="width: {{ $campaignProgress ?? 60 }}%" 
                                             aria-valuenow="{{ $campaignProgress ?? 60 }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Recent Activity -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-history text-primary me-2"></i>Recent Donations
                                </h6>
                                <div class="recent-donations">
                                    @forelse($recentDonations ?? [] as $donation)
                                    <div class="donation-item d-flex align-items-center p-3 bg-light rounded-3 mb-2">
                                        <div class="donor-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">{{ $donation->donor->full_name ?? 'Anonymous Donor' }}</h6>
                                                    <small class="text-muted">{{ $donation->donation_date->diffForHumans() ?? '2 hours ago' }}</small>
                                                </div>
                                                <div class="text-end">
                                                    <span class="fw-bold text-success">${{ number_format($donation->amount ?? 250, 0) }}</span>
                                                    <br>
                                                    <span class="badge bg-success-light text-success">{{ ucfirst($donation->status ?? 'completed') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="donation-item d-flex align-items-center p-3 bg-light rounded-3 mb-2">
                                        <div class="donor-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Sarah Johnson</h6>
                                                    <small class="text-muted">2 hours ago</small>
                                                </div>
                                                <div class="text-end">
                                                    <span class="fw-bold text-success">$250</span>
                                                    <br>
                                                    <span class="badge bg-success-light text-success">Completed</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="donation-item d-flex align-items-center p-3 bg-light rounded-3 mb-2">
                                        <div class="donor-avatar bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Michael Chen</h6>
                                                    <small class="text-muted">4 hours ago</small>
                                                </div>
                                                <div class="text-end">
                                                    <span class="fw-bold text-success">$500</span>
                                                    <br>
                                                    <span class="badge bg-success-light text-success">Completed</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="donation-item d-flex align-items-center p-3 bg-light rounded-3 mb-2">
                                        <div class="donor-avatar bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Anonymous</h6>
                                                    <small class="text-muted">6 hours ago</small>
                                                </div>
                                                <div class="text-end">
                                                    <span class="fw-bold text-success">$100</span>
                                                    <br>
                                                    <span class="badge bg-success-light text-success">Completed</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ route('campaigns.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-2"></i>View All Campaigns
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Elements -->
                    <div class="floating-element position-absolute" style="top: -20px; right: -20px; z-index: 1;">
                        <div class="bg-success text-white rounded-circle p-3 shadow">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="floating-element position-absolute" style="bottom: -15px; left: -15px; z-index: 1;">
                        <div class="bg-warning text-white rounded-circle p-2 shadow">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}

.stat-card-modern {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.stat-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.donation-item {
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.donation-item:hover {
    background-color: white !important;
    border-color: #dee2e6;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.bg-success-light {
    background-color: rgba(25, 135, 84, 0.1) !important;
}

.bg-primary-light {
    background-color: rgba(13, 110, 253, 0.1) !important;
}

.floating-element {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.campaign-progress-card {
    transition: all 0.3s ease;
}

.campaign-progress-card:hover {
    background-color: white !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
</style> 