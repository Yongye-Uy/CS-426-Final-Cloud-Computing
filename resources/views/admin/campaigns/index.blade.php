<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign Management - Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <style>
        :root {
            --primary-color: #2C3E50;
            --accent-color: #18BC9C;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
        }
        
        .admin-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-3px);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        
        .bg-pending { background: var(--warning-color); }
        .bg-approved { background: var(--success-color); }
        .bg-rejected { background: var(--danger-color); }
        .bg-total { background: var(--primary-color); }
        
        .campaign-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-approved {
            background: #d1edff;
            color: #0c5460;
        }
        
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 5px;
        }
        
        .navbar {
            background: white !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        
        .navbar-brand, .nav-link {
            color: var(--primary-color) !important;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-hand-holding-heart me-2"></i>
                {{ config('app.name', 'Donation Tracker') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('campaigns.index') }}">Campaigns</a>
                    </li>
                    @auth
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle btn btn-outline-primary" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                                <span class="badge bg-warning text-dark ms-1">Admin</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Admin Header -->
    <section class="admin-header mt-5 pt-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">
                        <i class="fas fa-tasks me-3"></i>Campaign Management
                    </h1>
                    <p class="lead mb-0">Review, approve, and manage all fundraising campaigns</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Cards -->
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-total me-3">
                            <i class="fas fa-list"></i>
                        </div>
                        <div>
                            <h3 class="mb-1">{{ $stats['total_campaigns'] }}</h3>
                            <p class="text-muted mb-0">Total Campaigns</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-pending me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h3 class="mb-1">{{ $stats['pending_campaigns'] }}</h3>
                            <p class="text-muted mb-0">Pending Review</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-approved me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h3 class="mb-1">{{ $stats['approved_campaigns'] }}</h3>
                            <p class="text-muted mb-0">Approved</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-rejected me-3">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div>
                            <h3 class="mb-1">{{ $stats['rejected_campaigns'] }}</h3>
                            <p class="text-muted mb-0">Rejected</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Campaigns Table -->
        <div class="campaign-table">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="campaignsTable">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>Campaign</th>
                            <th>Creator</th>
                            <th>Goal</th>
                            <th>Raised</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $campaign)
                            <tr>
                                <td>
                                    <input type="checkbox" name="campaigns[]" value="{{ $campaign->id }}" class="form-check-input campaign-checkbox">
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ Str::limit($campaign->name, 30) }}</h6>
                                        <small class="text-muted">{{ Str::limit($campaign->description, 50) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-circle me-2 text-muted"></i>
                                        {{ $campaign->creator ? $campaign->creator->name : 'Unknown' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold">${{ number_format($campaign->goal_amount) }}</span>
                                </td>
                                <td>
                                    <span class="text-success fw-bold">${{ number_format($campaign->raised_amount) }}</span>
                                    @if($campaign->goal_amount > 0)
                                        <br><small class="text-muted">{{ round(($campaign->raised_amount / $campaign->goal_amount) * 100) }}%</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $campaign->approval_status }}">
                                        {{ ucfirst($campaign->approval_status) }}
                                    </span>
                                    @if($campaign->isApproved())
                                        <br><small class="badge bg-secondary mt-1">{{ ucfirst($campaign->status) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $campaign->created_at->format('M j, Y') }}</small>
                                    <br><small class="text-muted">{{ $campaign->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.campaigns.show', $campaign) }}" class="btn btn-outline-primary btn-action">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($campaign->isPending())
                                            <button type="button" class="btn btn-outline-success btn-action" 
                                                    onclick="approveConfirm({{ $campaign->id }}, '{{ $campaign->name }}')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <a href="{{ route('admin.campaigns.reject-form', $campaign) }}" class="btn btn-outline-danger btn-action">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @endif
                                        
                                        <button type="button" class="btn btn-outline-danger btn-action" 
                                                onclick="deleteConfirm({{ $campaign->id }}, '{{ $campaign->name }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="mt-3">
            <div class="d-flex align-items-center">
                <select class="form-select me-2" id="bulkAction" style="width: auto;">
                    <option value="">Bulk Actions</option>
                    <option value="approve">Approve Selected</option>
                    <option value="reject">Reject Selected</option>
                    <option value="delete">Delete Selected</option>
                </select>
                <button type="button" class="btn btn-primary" onclick="executeBulkAction()">Apply</button>
                <span class="ms-3 text-muted" id="selectedCount">0 campaigns selected</span>
            </div>
        </div>
    </div>

    <!-- Hidden Forms for Actions -->
    <form id="approveForm" method="POST" style="display: none;">
        @csrf
    </form>

    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <form id="bulkActionForm" method="POST" action="{{ route('admin.campaigns.bulk-action') }}" style="display: none;">
        @csrf
        <input type="hidden" name="action" id="bulkActionType">
        <div id="bulkCampaignIds"></div>
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#campaignsTable').DataTable({
                pageLength: 25,
                order: [[6, 'desc']], // Sort by created date
                columnDefs: [
                    { orderable: false, targets: [0, 7] } // Disable sorting for checkbox and actions
                ]
            });

            // Select all functionality
            $('#selectAll').change(function() {
                $('.campaign-checkbox').prop('checked', $(this).prop('checked'));
                updateSelectedCount();
            });

            // Individual checkbox change
            $('.campaign-checkbox').change(function() {
                updateSelectedCount();
                
                // Update select all checkbox
                const totalCheckboxes = $('.campaign-checkbox').length;
                const checkedCheckboxes = $('.campaign-checkbox:checked').length;
                $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
            });

            function updateSelectedCount() {
                const count = $('.campaign-checkbox:checked').length;
                $('#selectedCount').text(count + ' campaign' + (count !== 1 ? 's' : '') + ' selected');
            }
        });

        function approveConfirm(id, name) {
            if (confirm(`Are you sure you want to approve the campaign "${name}"?`)) {
                const form = document.getElementById('approveForm');
                form.action = `/admin/campaigns/${id}/approve`;
                form.submit();
            }
        }

        function deleteConfirm(id, name) {
            if (confirm(`Are you sure you want to delete the campaign "${name}"? This action cannot be undone.`)) {
                const form = document.getElementById('deleteForm');
                form.action = `/admin/campaigns/${id}`;
                form.submit();
            }
        }

        function executeBulkAction() {
            const action = document.getElementById('bulkAction').value;
            const selectedCampaigns = Array.from(document.querySelectorAll('.campaign-checkbox:checked')).map(cb => cb.value);

            if (!action) {
                alert('Please select an action.');
                return;
            }

            if (selectedCampaigns.length === 0) {
                alert('Please select at least one campaign.');
                return;
            }

            let confirmMessage = `Are you sure you want to ${action} ${selectedCampaigns.length} campaign(s)?`;
            if (action === 'delete') {
                confirmMessage += ' This action cannot be undone.';
            }

            if (confirm(confirmMessage)) {
                document.getElementById('bulkActionType').value = action;
                
                // Add selected campaign IDs to form
                const bulkCampaignIds = document.getElementById('bulkCampaignIds');
                bulkCampaignIds.innerHTML = '';
                selectedCampaigns.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'campaigns[]';
                    input.value = id;
                    bulkCampaignIds.appendChild(input);
                });

                document.getElementById('bulkActionForm').submit();
            }
        }
    </script>
</body>
</html>
