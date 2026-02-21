<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 120px; height: 120px; font-size: 48px;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                
                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-2">{{ $user->role->name ?? 'No Role' }}</p>
                
                @if($user->isAdmin())
                    <span class="badge bg-danger mb-3">
                        <i class="fas fa-crown me-1"></i>Administrator
                    </span>
                @endif
                
                <div class="text-start">
                    <p class="mb-2">
                        <i class="fas fa-envelope text-primary me-2"></i>
                        <strong>Email:</strong> {{ $user->email }}
                    </p>
                    
                    @if($user->phone)
                        <p class="mb-2">
                            <i class="fas fa-phone text-primary me-2"></i>
                            <strong>Phone:</strong> {{ $user->phone }}
                        </p>
                    @endif
                    
                    @if($user->organization)
                        <p class="mb-2">
                            <i class="fas fa-building text-primary me-2"></i>
                            <strong>Organization:</strong> {{ $user->organization }}
                        </p>
                    @endif
                    
                    <p class="mb-2">
                        <i class="fas fa-calendar text-primary me-2"></i>
                        <strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}
                    </p>
                    
                    <p class="mb-0">
                        <i class="fas fa-clock text-primary me-2"></i>
                        <strong>Last Updated:</strong> {{ $user->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>User Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="flex-shrink-0">
                                <i class="fas fa-bullseye fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Total Campaigns</h6>
                                <h4 class="mb-0 text-primary">{{ $stats['total_campaigns'] }}</h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="flex-shrink-0">
                                <i class="fas fa-play-circle fa-2x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Active Campaigns</h6>
                                <h4 class="mb-0 text-success">{{ $stats['active_campaigns'] }}</h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Pending Approval</h6>
                                <h4 class="mb-0 text-warning">{{ $stats['pending_campaigns'] }}</h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle fa-2x text-info"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Approved Campaigns</h6>
                                <h4 class="mb-0 text-info">{{ $stats['approved_campaigns'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @if($user->campaigns->count() > 0)
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Recent Campaigns
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Goal</th>
                                    <th>Status</th>
                                    <th>Approval</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->campaigns->take(5) as $campaign)
                                    <tr>
                                        <td>
                                            <strong>{{ Str::limit($campaign->title, 30) }}</strong>
                                        </td>
                                        <td>${{ number_format($campaign->goal_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $campaign->status === 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($campaign->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $campaign->approval_status === 'approved' ? 'success' : ($campaign->approval_status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($campaign->approval_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $campaign->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div> 