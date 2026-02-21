<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Donation Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2C3E50;
            --secondary-color: #ffffff;
            --accent-color: #18BC9C;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--primary-color);
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1a252f;
            border-color: #1a252f;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .hero-section {
            background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)), url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .card {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        
        .card:hover {
            transform: translateY(-10px);
        }
        
        .dashboard-card {
            border-left: 5px solid var(--primary-color);
        }
        
        .stat-card {
            border-radius: 10px;
            color: white;
        }
        
        .stat-card-1 {
            background-color: #3498DB;
        }
        
        .stat-card-2 {
            background-color: #2ECC71;
        }
        
        .stat-card-3 {
            background-color: #E74C3C;
        }
        
        .stat-card-4 {
            background-color: #F39C12;
        }
        
        .donation-progress {
            height: 10px;
        }
        
        .donor-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .testimonial-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        footer {
            background-color: #1a252f;
            color: white;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.1);
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-icon:hover {
            background-color: var(--accent-color);
            color: white;
        }
        
        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
        }
        
        .nav-pills .nav-link {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-hand-holding-heart me-2"></i>
                <strong><?php echo SITE_NAME; ?></strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">How It Works</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <?php if (isLoggedIn()): ?>
                            <a class="btn btn-outline-light" href="dashboard.php">Dashboard</a>
                        <?php else: ?>
                            <a class="btn btn-outline-light" href="login.php">Login</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container py-5 mt-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Streamline Your Donation Management</h1>
                    <p class="lead mb-4"><?php echo SITE_NAME; ?> helps nonprofits and charities efficiently track, manage, and optimize their donation processes with our comprehensive management system.</p>
                    <div class="d-flex gap-3">
                        <a href="#demo" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-play-circle me-2"></i> Watch Demo
                        </a>
                        <a href="register.php" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-user-plus me-2"></i> Sign Up Free
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Donation Management" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-4">
                        <h2 class="display-4 fw-bold text-primary">1,250+</h2>
                        <p class="mb-0 fw-semibold">Nonprofits Trust Us</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-4">
                        <h2 class="display-4 fw-bold text-primary">$<?php echo number_format(getTotalDonations($pdo)); ?>+</h2>
                        <p class="mb-0 fw-semibold">Donations Processed</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-4">
                        <h2 class="display-4 fw-bold text-primary">24/7</h2>
                        <p class="mb-0 fw-semibold">Support Available</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-4">
                        <h2 class="display-4 fw-bold text-primary">99.9%</h2>
                        <p class="mb-0 fw-semibold">Uptime Guarantee</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Powerful Features for Your Organization</h2>
                <p class="lead text-muted">Everything you need to manage donations effectively</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 p-4">
                        <div class="feature-icon">
                            <i class="fas fa-donate"></i>
                        </div>
                        <h4>Donation Tracking</h4>
                        <p>Track all donations in real-time with detailed records of donor information, amounts, dates, and purposes.</p>
                        <ul class="text-muted">
                            <li>Real-time donation monitoring</li>
                            <li>Customizable donation forms</li>
                            <li>Recurring donation management</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 p-4">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Donor Management</h4>
                        <p>Maintain comprehensive donor profiles with contact information, donation history, and communication logs.</p>
                        <ul class="text-muted">
                            <li>Donor segmentation</li>
                            <li>Relationship tracking</li>
                            <li>Donor engagement scoring</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 p-4">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Reporting & Analytics</h4>
                        <p>Generate detailed reports and visualize your donation data with interactive dashboards and charts.</p>
                        <ul class="text-muted">
                            <li>Custom report builder</li>
                            <li>Financial summaries</li>
                            <li>Donation trend analysis</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 p-4">
                        <div class="feature-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <h4>Automated Receipts</h4>
                        <p>Automatically generate and send tax receipts to donors with your branding and custom messages.</p>
                        <ul class="text-muted">
                            <li>Customizable templates</li>
                            <li>Automatic tax compliance</li>
                            <li>Email and print options</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 p-4">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4>Mobile Responsive</h4>
                        <p>Access your donation data from anywhere with our fully responsive web application and mobile app.</p>
                        <ul class="text-muted">
                            <li>iOS and Android apps</li>
                            <li>Offline capability</li>
                            <li>Mobile donation forms</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 p-4">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Security & Compliance</h4>
                        <p>Bank-level security and compliance with all financial regulations to protect your donors' information.</p>
                        <ul class="text-muted">
                            <li>PCI DSS compliant</li>
                            <li>GDPR ready</li>
                            <li>Regular security audits</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">How <?php echo SITE_NAME; ?> Works</h2>
                <p class="lead text-muted">Simple steps to manage your donations effectively</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 text-center bg-transparent">
                        <div class="card-body">
                            <div class="bg-primary text-white rounded-circle p-4 d-inline-block mb-3">
                                <i class="fas fa-user-plus fa-2x"></i>
                            </div>
                            <h5>1. Add Donors</h5>
                            <p class="text-muted">Import existing donors or add new ones manually or through our API.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 text-center bg-transparent">
                        <div class="card-body">
                            <div class="bg-primary text-white rounded-circle p-4 d-inline-block mb-3">
                                <i class="fas fa-hand-holding-usd fa-2x"></i>
                            </div>
                            <h5>2. Record Donations</h5>
                            <p class="text-muted">Log donations with all relevant details including amount, date, and purpose.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 text-center bg-transparent">
                        <div class="card-body">
                            <div class="bg-primary text-white rounded-circle p-4 d-inline-block mb-3">
                                <i class="fas fa-envelope fa-2x"></i>
                            </div>
                            <h5>3. Send Receipts</h5>
                            <p class="text-muted">Automatically generate and send tax receipts to your donors.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 border-0 text-center bg-transparent">
                        <div class="card-body">
                            <div class="bg-primary text-white rounded-circle p-4 d-inline-block mb-3">
                                <i class="fas fa-chart-pie fa-2x"></i>
                            </div>
                            <h5>4. Analyze & Report</h5>
                            <p class="text-muted">Generate reports and analyze your donation trends and patterns.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="#demo" class="btn btn-primary btn-lg px-4">
                    <i class="fas fa-play-circle me-2"></i> Watch Full Demo
                </a>
            </div>
        </div>
    </section>

    <!-- Dashboard Preview Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Intuitive Dashboard for Complete Overview</h2>
                    <p class="lead mb-4">Our clean, user-friendly dashboard gives you instant access to all critical donation metrics and activities.</p>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-chart-bar text-primary me-2"></i> Real-time Analytics</h5>
                        <p>Monitor donation trends, compare periods, and identify your most active donors.</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-bell text-primary me-2"></i> Smart Notifications</h5>
                        <p>Get alerts for large donations, recurring payment failures, or donor anniversaries.</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-tasks text-primary me-2"></i> Task Management</h5>
                        <p>Track follow-ups, thank you notes, and other donor engagement activities.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Donation Dashboard</span>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        This Month
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Week</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            $campaignProgress = getCampaignProgress($pdo, 1); // Get first campaign progress
                            $recentDonations = getRecentDonations($pdo, 3);
                            ?>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="stat-card stat-card-1 p-3 rounded">
                                        <h6 class="mb-0">Total Donations</h6>
                                        <h3 class="mb-0">$<?php echo number_format(getTotalDonations($pdo), 2); ?></h3>
                                        <small>+12% from last month</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-card stat-card-2 p-3 rounded">
                                        <h6 class="mb-0">New Donors</h6>
                                        <h3 class="mb-0">48</h3>
                                        <small>+5 from last month</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-card stat-card-3 p-3 rounded">
                                        <h6 class="mb-0">Pending Tasks</h6>
                                        <h3 class="mb-0">12</h3>
                                        <small>3 overdue</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="stat-card stat-card-4 p-3 rounded">
                                        <h6 class="mb-0">Campaign Progress</h6>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span><?php echo round($campaignProgress['progress_percentage'] ?? 0); ?>%</span>
                                            <span>$<?php echo number_format($campaignProgress['raised_amount'] ?? 0, 2); ?>/$<?php echo number_format($campaignProgress['goal_amount'] ?? 0, 2); ?></span>
                                        </div>
                                        <div class="progress donation-progress">
                                            <div class="progress-bar" role="progressbar" style="width: <?php echo ($campaignProgress['progress_percentage'] ?? 0); ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h6 class="mb-3">Recent Donations</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Donor</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recentDonations as $donation): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/9131/9131529.png" class="donor-img me-2" alt="Donor Image">

                                                        <span><?php echo $donation['first_name'] . ' ' . $donation['last_name']; ?></span>
                                                    </div>
                                                </td>
                                                <td>$<?php echo number_format($donation['amount'], 2); ?></td>
                                                <td><?php echo formatDate($donation['donation_date']); ?></td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">What Our Clients Say</h2>
                <p class="lead text-muted">Trusted by nonprofits and charities worldwide</p>
            </div>
            
            <div class="row g-4">
                <?php foreach (getTestimonials($pdo, 3, true) as $testimonial): ?>
                <div class="col-lg-4">
                    <div class="card h-100 p-4">
                        <div class="text-center mb-4">
                            <img src="https://randomuser.me/api/portraits/<?php echo rand(0, 1) ? 'men' : 'women'; ?>/<?php echo rand(1, 99); ?>.jpg" class="testimonial-img mb-3">
                            <div class="d-flex justify-content-center text-warning mb-2">
                                <?php 
                                $fullStars = floor($testimonial['rating']);
                                $halfStar = ($testimonial['rating'] - $fullStars) >= 0.5;
                                
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $fullStars) {
                                        echo '<i class="fas fa-star"></i>';
                                    } elseif ($i == $fullStars + 1 && $halfStar) {
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                            <h5 class="mb-1"><?php echo $testimonial['donor_name']; ?></h5>
                            <small class="text-muted"><?php echo $testimonial['donor_title']; ?></small>
                        </div>
                        <p class="text-muted">"<?php echo $testimonial['content']; ?>"</p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-3">Ready to Transform Your Donation Management?</h2>
                    <p class="lead mb-0">Join thousands of nonprofits who trust <?php echo SITE_NAME; ?> to manage their donations efficiently.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <a href="register.php" class="btn btn-light btn-lg px-4 me-2">Start Free Trial</a>
                    <a href="#demo" class="btn btn-outline-light btn-lg px-4">Schedule Demo</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Frequently Asked Questions</h2>
                <p class="lead text-muted">Find answers to common questions about <?php echo SITE_NAME; ?></p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    Is <?php echo SITE_NAME; ?> secure for processing donations?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, <?php echo SITE_NAME; ?> uses bank-level 256-bit SSL encryption and is PCI DSS compliant. We never store full credit card numbers on our servers and partner with trusted payment processors to ensure your donors' information is always secure.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    Can I import data from my current system?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Absolutely. <?php echo SITE_NAME; ?> supports CSV imports for donors, donations, and other data. We also offer dedicated migration assistance for larger imports from common systems like Raiser's Edge, DonorPerfect, and Salesforce. Our support team can help ensure a smooth transition.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    How does the free trial work?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Our free trial gives you full access to all Professional plan features for 14 days, no credit card required. You can add up to 100 test donations during this period to evaluate the system. At the end of the trial, you can choose a plan or export your data if you decide not to continue.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                    Do you offer discounts for nonprofits?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, registered 501(c)(3) organizations qualify for a 15% discount on all plans. Educational institutions and places of worship may also qualify for special pricing. Contact our sales team with proof of your nonprofit status to receive your discount code.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 shadow-sm">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                    What payment methods do you support?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <?php echo SITE_NAME; ?> integrates with all major payment processors including Stripe, PayPal, Authorize.Net, and more. This allows you to accept credit/debit cards, ACH bank transfers, Apple Pay, Google Pay, and in some cases, cryptocurrency donations. You can also record cash and check donations manually.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Contact Our Team</h2>
                    <p class="lead mb-4">Have questions or need assistance? We're here to help!</p>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-envelope text-primary me-2"></i> Email Us</h5>
                        <p><?php echo SITE_EMAIL; ?></p>
                    </div>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-phone text-primary me-2"></i> Call Us</h5>
                        <p>+1 (800) 555-9876</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-map-marker-alt text-primary me-2"></i> Visit Us</h5>
                        <p>123 Nonprofit Way, Suite 200<br>San Francisco, CA 94107</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-clock text-primary me-2"></i> Support Hours</h5>
                        <p>Monday-Friday: 8am-8pm EST<br>Saturday: 10am-4pm EST</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <h4 class="mb-4">Send Us a Message</h4>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                $name = sanitize($_POST['name']);
                                $email = sanitize($_POST['email']);
                                $organization = sanitize($_POST['organization']);
                                $subject = sanitize($_POST['subject']);
                                $message = sanitize($_POST['message']);
                                
                                if (addContactMessage($pdo, $name, $email, $organization, $subject, $message)) {
                                    echo '<div class="alert alert-success">Thank you for your message! We will get back to you soon.</div>';
                                } else {
                                    echo '<div class="alert alert-danger">There was an error sending your message. Please try again.</div>';
                                }
                            }
                            ?>
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="organization" class="form-label">Organization (Optional)</label>
                                    <input type="text" class="form-control" id="organization" name="organization">
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <select class="form-select" id="subject" name="subject">
                                        <option>General Inquiry</option>
                                        <option>Sales Questions</option>
                                        <option>Technical Support</option>
                                        <option>Billing Questions</option>
                                        <option>Feature Request</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="text-white mb-4">
                        <i class="fas fa-hand-holding-heart me-2"></i>
                        <strong><?php echo SITE_NAME; ?></strong>
                    </h5>
                    <p><?php echo SITE_NAME; ?> helps nonprofits and charities efficiently track, manage, and optimize their donation processes with our comprehensive management system.</p>
                    <div class="mt-4">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white mb-4">Product</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#features" class="text-white-50 text-decoration-none">Features</a></li>
                        <li class="mb-2"><a href="#pricing" class="text-white-50 text-decoration-none">Pricing</a></li>
                        <li class="mb-2"><a href="#demo" class="text-white-50 text-decoration-none">Demo</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Updates</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Roadmap</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white mb-4">Company</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Careers</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Blog</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Press</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Partners</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white mb-4">Resources</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Help Center</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Community</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Webinars</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Tutorials</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">API Docs</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="text-white mb-4">Legal</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Privacy</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Terms</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Security</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Compliance</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">GDPR</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small text-white-50 mb-0">© <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="small text-white-50 mb-0">Made with <i class="fas fa-heart text-danger"></i> for nonprofits</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>