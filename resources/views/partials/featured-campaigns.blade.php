<!-- Featured Campaigns Section -->
<section id="featured-campaigns" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-5 fw-bold text-primary mb-3">Featured Campaigns</h2>
                <p class="lead text-muted">Support these active campaigns and make a meaningful impact in communities worldwide</p>
            </div>
        </div>
        
        <div class="row g-4">
            @forelse($featuredCampaigns as $campaign)
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card h-100 campaign-card-home">
                        <!-- Campaign Image -->
                        <div class="campaign-media position-relative">
                            <img src="{{ $campaign->getCampaignImage() }}" class="card-img-top campaign-img" alt="{{ $campaign->name }}">
                            @if($campaign->video_url)
                                <div class="video-indicator">
                                    <i class="fas fa-video me-1"></i>Has Video
                                </div>
                            @endif
                            
                            <div class="campaign-status-badge">
                                <i class="fas fa-circle-check me-1"></i>{{ ucfirst($campaign->status) }}
                            </div>
                            
                            @if($campaign->end_date && $campaign->end_date->isFuture())
                                <div class="days-remaining">
                                        <i class="fas fa-clock me-1"></i>{{ floor(abs($campaign->end_date->diffInDays())) }} days left
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $campaign->name }}</h5>
                            <p class="card-text text-muted flex-grow-1">{{ Str::limit($campaign->description, 100) }}</p>
                            
                            <!-- Progress Bar -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Progress</small>
                                    <small class="fw-bold text-primary">{{ $campaign->progress_percentage }}%</small>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: {{ $campaign->progress_percentage }}%" 
                                         aria-valuenow="{{ $campaign->progress_percentage }}" 
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            
                            <!-- Campaign Stats -->
                            <div class="row text-center mb-3">
                                <div class="col-4">
                                    <div class="stat-small">
                                        <div class="fw-bold text-success">${{ number_format($campaign->raised_amount) }}</div>
                                        <small class="text-muted">Raised</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-small">
                                        <div class="fw-bold">${{ number_format($campaign->goal_amount) }}</div>
                                        <small class="text-muted">Goal</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-small">
                                        <div class="fw-bold">{{ $campaign->donations()->count() }}</div>
                                        <small class="text-muted">Donors</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-info-circle me-2"></i>Learn More
                                </a>
                                <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-success btn-sm donate-btn">
                                    <i class="fas fa-heart me-2"></i>Donate Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-bullseye text-muted mb-3" style="font-size: 3rem;"></i>
                    <h4 class="text-muted">No Featured Campaigns</h4>
                    <p class="text-muted">Check back soon for new fundraising opportunities.</p>
                </div>
            @endforelse
        </div>
        
        @if($featuredCampaigns->count() > 0)
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="{{ route('campaigns.index') }}" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-bullseye me-2"></i>View All Campaigns
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<style>
.campaign-card-home {
    border: none;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.campaign-card-home:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

.campaign-media {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.campaign-img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.campaign-card-home:hover .campaign-img {
    transform: scale(1.05);
}

.video-thumbnail {
    height: 100%;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    cursor: pointer;
}

.play-button {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--primary-color);
    transition: all 0.3s ease;
}

.play-button:hover {
    background: white;
    transform: scale(1.1);
}

.video-indicator {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(231, 76, 60, 0.9);
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.campaign-status-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: var(--accent-color);
    color: white;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
}

.days-remaining {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background: #f39c12;
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.stat-small {
    padding: 0.5rem 0;
}

.donate-btn {
    background: linear-gradient(45deg, #27ae60, #18BC9C);
    border: none;
    transition: all 0.3s ease;
}

.donate-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
}
</style> 