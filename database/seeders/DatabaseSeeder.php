<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Donor;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Testimonial;
use App\Models\ContactMessage;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First seed the roles
        $this->call(RoleSeeder::class);

        // Create admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@donationtracker.com'],
            [
                'name' => 'Admin User',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role_id' => 1, // Admin role
            ]
        );

        // Create regular user
        $regularUser = User::firstOrCreate(
            ['email' => 'user@donationtracker.com'],
            [
                'name' => 'John Doe',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role_id' => 2, // User role
            ]
        );

        // Create comprehensive donor database
        $donors = [
            // Individual Donors
            ['first_name' => 'Alexander', 'last_name' => 'Thompson', 'email' => 'alex.thompson@gmail.com', 'phone' => '(555) 123-4567', 'address' => '123 Maple Street', 'city' => 'San Francisco', 'state' => 'CA', 'country' => 'USA', 'postal_code' => '94102', 'donor_type' => 'individual'],
            ['first_name' => 'Maria', 'last_name' => 'Rodriguez', 'email' => 'maria.rodriguez@outlook.com', 'phone' => '(555) 234-5678', 'address' => '456 Oak Avenue', 'city' => 'Los Angeles', 'state' => 'CA', 'country' => 'USA', 'postal_code' => '90210', 'donor_type' => 'individual'],
            ['first_name' => 'David', 'last_name' => 'Chen', 'email' => 'david.chen@yahoo.com', 'phone' => '(555) 345-6789', 'address' => '789 Pine Road', 'city' => 'Seattle', 'state' => 'WA', 'country' => 'USA', 'postal_code' => '98101', 'donor_type' => 'individual'],
            ['first_name' => 'Sarah', 'last_name' => 'Johnson', 'email' => 'sarah.johnson@gmail.com', 'phone' => '(555) 456-7890', 'address' => '321 Elm Street', 'city' => 'Portland', 'state' => 'OR', 'country' => 'USA', 'postal_code' => '97201', 'donor_type' => 'individual'],
            ['first_name' => 'Michael', 'last_name' => 'Brown', 'email' => 'michael.brown@hotmail.com', 'phone' => '(555) 567-8901', 'address' => '654 Cedar Lane', 'city' => 'Denver', 'state' => 'CO', 'country' => 'USA', 'postal_code' => '80202', 'donor_type' => 'individual'],
            ['first_name' => 'Jennifer', 'last_name' => 'Davis', 'email' => 'jennifer.davis@gmail.com', 'phone' => '(555) 678-9012', 'address' => '987 Birch Drive', 'city' => 'Austin', 'state' => 'TX', 'country' => 'USA', 'postal_code' => '73301', 'donor_type' => 'individual'],
            ['first_name' => 'Robert', 'last_name' => 'Wilson', 'email' => 'robert.wilson@outlook.com', 'phone' => '(555) 789-0123', 'address' => '147 Willow Way', 'city' => 'Miami', 'state' => 'FL', 'country' => 'USA', 'postal_code' => '33101', 'donor_type' => 'individual'],
            ['first_name' => 'Emily', 'last_name' => 'Garcia', 'email' => 'emily.garcia@yahoo.com', 'phone' => '(555) 890-1234', 'address' => '258 Spruce Street', 'city' => 'Phoenix', 'state' => 'AZ', 'country' => 'USA', 'postal_code' => '85001', 'donor_type' => 'individual'],
            ['first_name' => 'James', 'last_name' => 'Martinez', 'email' => 'james.martinez@gmail.com', 'phone' => '(555) 901-2345', 'address' => '369 Fir Avenue', 'city' => 'Boston', 'state' => 'MA', 'country' => 'USA', 'postal_code' => '02101', 'donor_type' => 'individual'],
            ['first_name' => 'Lisa', 'last_name' => 'Anderson', 'email' => 'lisa.anderson@hotmail.com', 'phone' => '(555) 012-3456', 'address' => '741 Aspen Court', 'city' => 'Chicago', 'state' => 'IL', 'country' => 'USA', 'postal_code' => '60601', 'donor_type' => 'individual'],
            
            // Corporate Donors
            ['first_name' => 'Microsoft Corporation', 'last_name' => '', 'email' => 'giving@microsoft.com', 'phone' => '(425) 882-8080', 'address' => 'One Microsoft Way', 'city' => 'Redmond', 'state' => 'WA', 'country' => 'USA', 'postal_code' => '98052', 'donor_type' => 'corporate'],
            ['first_name' => 'Google LLC', 'last_name' => '', 'email' => 'donations@google.org', 'phone' => '(650) 253-0000', 'address' => '1600 Amphitheatre Parkway', 'city' => 'Mountain View', 'state' => 'CA', 'country' => 'USA', 'postal_code' => '94043', 'donor_type' => 'corporate'],
            ['first_name' => 'Amazon Web Services', 'last_name' => '', 'email' => 'community@amazon.com', 'phone' => '(206) 266-1000', 'address' => '410 Terry Avenue North', 'city' => 'Seattle', 'state' => 'WA', 'country' => 'USA', 'postal_code' => '98109', 'donor_type' => 'corporate'],
            ['first_name' => 'Apple Inc', 'last_name' => '', 'email' => 'giving@apple.com', 'phone' => '(408) 996-1010', 'address' => 'One Apple Park Way', 'city' => 'Cupertino', 'state' => 'CA', 'country' => 'USA', 'postal_code' => '95014', 'donor_type' => 'corporate'],
            ['first_name' => 'Tesla Foundation', 'last_name' => '', 'email' => 'foundation@tesla.com', 'phone' => '(512) 516-8177', 'address' => '1 Tesla Road', 'city' => 'Austin', 'state' => 'TX', 'country' => 'USA', 'postal_code' => '78725', 'donor_type' => 'corporate'],
            
            // Foundation Donors
            ['first_name' => 'Gates Foundation', 'last_name' => '', 'email' => 'info@gatesfoundation.org', 'phone' => '(206) 709-3100', 'address' => '440 5th Avenue North', 'city' => 'Seattle', 'state' => 'WA', 'country' => 'USA', 'postal_code' => '98109', 'donor_type' => 'foundation'],
            ['first_name' => 'Ford Foundation', 'last_name' => '', 'email' => 'office@fordfoundation.org', 'phone' => '(212) 573-5000', 'address' => '320 E 43rd Street', 'city' => 'New York', 'state' => 'NY', 'country' => 'USA', 'postal_code' => '10017', 'donor_type' => 'foundation'],
            ['first_name' => 'Rockefeller Foundation', 'last_name' => '', 'email' => 'info@rockefellerfoundation.org', 'phone' => '(212) 869-8500', 'address' => '420 5th Avenue', 'city' => 'New York', 'state' => 'NY', 'country' => 'USA', 'postal_code' => '10018', 'donor_type' => 'foundation'],
        ];

        foreach ($donors as $donorData) {
            Donor::create($donorData);
        }

        // Create realistic fundraising campaigns
        $campaigns = [
            [
                'name' => 'Clean Water for All Initiative',
                'description' => 'Providing access to clean, safe drinking water for communities in developing countries. This comprehensive program includes well drilling, water purification systems, and community education.',
                'goal_amount' => 150000.00,
                'raised_amount' => 127500.00,
                'start_date' => Carbon::now()->subDays(120),
                'end_date' => Carbon::now()->addDays(45),
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=A67ZkAd1wmI'
            ],
            [
                'name' => 'Education Excellence Program',
                'description' => 'Supporting quality education in underserved communities through teacher training, classroom resources, technology access, and scholarship programs for deserving students.',
                'goal_amount' => 200000.00,
                'raised_amount' => 165000.00,
                'start_date' => Carbon::now()->subDays(90),
                'end_date' => Carbon::now()->addDays(60),
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=kMWxuF9YcQw'
            ],
            [
                'name' => 'Healthcare Access Initiative',
                'description' => 'Expanding healthcare access in rural areas through mobile health clinics, telemedicine programs, and training community health workers.',
                'goal_amount' => 300000.00,
                'raised_amount' => 185000.00,
                'start_date' => Carbon::now()->subDays(60),
                'end_date' => Carbon::now()->addDays(90),
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=lMbvtmb79N0'
            ],
            [
                'name' => 'Environmental Conservation Project',
                'description' => 'Protecting critical ecosystems through reforestation, wildlife conservation, and sustainable agriculture programs that benefit both nature and local communities.',
                'goal_amount' => 125000.00,
                'raised_amount' => 89000.00,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->addDays(120),
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=GQ1VIrJgNhw'
            ],
            [
                'name' => 'Emergency Relief Fund',
                'description' => 'Rapid response fund for natural disasters and humanitarian crises, providing immediate aid including food, shelter, medical supplies, and emergency services.',
                'goal_amount' => 500000.00,
                'raised_amount' => 450000.00,
                'start_date' => Carbon::now()->subDays(180),
                'end_date' => Carbon::now()->subDays(30),
                'status' => 'completed',
                'video_url' => null
            ],
            [
                'name' => 'Youth Development Program',
                'description' => 'Empowering young people through mentorship, skills training, leadership development, and entrepreneurship opportunities in urban and rural communities.',
                'goal_amount' => 175000.00,
                'raised_amount' => 95000.00,
                'start_date' => Carbon::now()->subDays(45),
                'end_date' => Carbon::now()->addDays(75),
                'status' => 'active',
                'video_url' => 'https://www.youtube.com/watch?v=WmVLcj-XKnM'
            ]
        ];

        foreach ($campaigns as $campaignData) {
            Campaign::create($campaignData);
        }

        // Create realistic donation records
        $donations = [
            // Major donations from foundations and corporations
            ['donor_id' => 16, 'campaign_id' => 5, 'amount' => 100000.00, 'donation_date' => Carbon::now()->subDays(150), 'payment_method' => 'bank_transfer', 'status' => 'completed', 'purpose' => 'Emergency Relief Operations'],
            ['donor_id' => 11, 'campaign_id' => 2, 'amount' => 75000.00, 'donation_date' => Carbon::now()->subDays(75), 'payment_method' => 'bank_transfer', 'status' => 'completed', 'purpose' => 'Technology Infrastructure for Schools'],
            ['donor_id' => 17, 'campaign_id' => 3, 'amount' => 50000.00, 'donation_date' => Carbon::now()->subDays(45), 'payment_method' => 'bank_transfer', 'status' => 'completed', 'purpose' => 'Mobile Health Clinic Equipment'],
            ['donor_id' => 12, 'campaign_id' => 1, 'amount' => 40000.00, 'donation_date' => Carbon::now()->subDays(90), 'payment_method' => 'bank_transfer', 'status' => 'completed', 'purpose' => 'Water Purification Systems'],
            ['donor_id' => 18, 'campaign_id' => 4, 'amount' => 30000.00, 'donation_date' => Carbon::now()->subDays(25), 'payment_method' => 'bank_transfer', 'status' => 'completed', 'purpose' => 'Reforestation Program'],
            
            // Individual major donations
            ['donor_id' => 1, 'campaign_id' => 1, 'amount' => 15000.00, 'donation_date' => Carbon::now()->subDays(100), 'payment_method' => 'credit_card', 'status' => 'completed', 'purpose' => 'Well Drilling Project'],
            ['donor_id' => 2, 'campaign_id' => 2, 'amount' => 12500.00, 'donation_date' => Carbon::now()->subDays(80), 'payment_method' => 'check', 'status' => 'completed', 'purpose' => 'Teacher Training Program'],
            ['donor_id' => 3, 'campaign_id' => 3, 'amount' => 20000.00, 'donation_date' => Carbon::now()->subDays(40), 'payment_method' => 'bank_transfer', 'status' => 'completed', 'purpose' => 'Medical Equipment'],
            ['donor_id' => 4, 'campaign_id' => 5, 'amount' => 8500.00, 'donation_date' => Carbon::now()->subDays(160), 'payment_method' => 'credit_card', 'status' => 'completed', 'purpose' => 'Emergency Food Supplies'],
            ['donor_id' => 5, 'campaign_id' => 4, 'amount' => 6000.00, 'donation_date' => Carbon::now()->subDays(20), 'payment_method' => 'online', 'status' => 'completed', 'purpose' => 'Wildlife Conservation'],
            
            // Regular donations
            ['donor_id' => 6, 'campaign_id' => 1, 'amount' => 2500.00, 'donation_date' => Carbon::now()->subDays(70), 'payment_method' => 'credit_card', 'status' => 'completed', 'purpose' => 'General Support'],
            ['donor_id' => 7, 'campaign_id' => 2, 'amount' => 3500.00, 'donation_date' => Carbon::now()->subDays(60), 'payment_method' => 'bank_transfer', 'status' => 'completed', 'purpose' => 'Scholarship Fund'],
            ['donor_id' => 8, 'campaign_id' => 3, 'amount' => 4200.00, 'donation_date' => Carbon::now()->subDays(35), 'payment_method' => 'credit_card', 'status' => 'completed', 'purpose' => 'Community Health'],
            ['donor_id' => 9, 'campaign_id' => 6, 'amount' => 1800.00, 'donation_date' => Carbon::now()->subDays(30), 'payment_method' => 'online', 'status' => 'completed', 'purpose' => 'Youth Leadership'],
            ['donor_id' => 10, 'campaign_id' => 4, 'amount' => 2200.00, 'donation_date' => Carbon::now()->subDays(15), 'payment_method' => 'credit_card', 'status' => 'completed', 'purpose' => 'Environmental Protection'],
            
            // Recent donations
            ['donor_id' => 1, 'campaign_id' => 6, 'amount' => 1500.00, 'donation_date' => Carbon::now()->subDays(10), 'payment_method' => 'credit_card', 'status' => 'completed', 'purpose' => 'Mentorship Program'],
            ['donor_id' => 3, 'campaign_id' => 1, 'amount' => 3200.00, 'donation_date' => Carbon::now()->subDays(8), 'payment_method' => 'bank_transfer', 'status' => 'completed', 'purpose' => 'Water Infrastructure'],
            ['donor_id' => 5, 'campaign_id' => 2, 'amount' => 2800.00, 'donation_date' => Carbon::now()->subDays(5), 'payment_method' => 'online', 'status' => 'completed', 'purpose' => 'Educational Resources'],
            ['donor_id' => 7, 'campaign_id' => 3, 'amount' => 5500.00, 'donation_date' => Carbon::now()->subDays(3), 'payment_method' => 'credit_card', 'status' => 'completed', 'purpose' => 'Healthcare Access'],
            ['donor_id' => 9, 'campaign_id' => 4, 'amount' => 1200.00, 'donation_date' => Carbon::now()->subDays(1), 'payment_method' => 'online', 'status' => 'completed', 'purpose' => 'Tree Planting'],
            
            // Recurring donations
            ['donor_id' => 2, 'campaign_id' => 1, 'amount' => 500.00, 'donation_date' => Carbon::now()->subDays(30), 'payment_method' => 'credit_card', 'status' => 'completed', 'is_recurring' => true, 'recurring_frequency' => 'monthly', 'purpose' => 'Monthly Support'],
            ['donor_id' => 4, 'campaign_id' => 2, 'amount' => 750.00, 'donation_date' => Carbon::now()->subDays(25), 'payment_method' => 'bank_transfer', 'status' => 'completed', 'is_recurring' => true, 'recurring_frequency' => 'monthly', 'purpose' => 'Monthly Education Support'],
            ['donor_id' => 6, 'campaign_id' => 3, 'amount' => 300.00, 'donation_date' => Carbon::now()->subDays(20), 'payment_method' => 'credit_card', 'status' => 'completed', 'is_recurring' => true, 'recurring_frequency' => 'monthly', 'purpose' => 'Monthly Healthcare Support'],
        ];

        foreach ($donations as $donationData) {
            Donation::create($donationData);
        }

        // Update campaign raised amounts based on actual donations
        $campaigns = Campaign::all();
        foreach ($campaigns as $campaign) {
            $campaign->updateRaisedAmount();
        }

        // Create realistic testimonials from actual nonprofit organizations
        $testimonials = [
            [
                'donor_name' => 'Dr. Sarah Chen',
                'donor_title' => 'Executive Director, Global Health Alliance',
                'content' => 'This donation management system has revolutionized our fundraising operations. The real-time analytics help us make data-driven decisions, and the automated receipt system saves our team countless hours. Our donor retention has increased by 35% since implementation.',
                'rating' => 5.0,
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'donor_name' => 'Michael Rodriguez',
                'donor_title' => 'Development Director, Education First Foundation',
                'content' => 'The comprehensive donor management features have transformed how we engage with our supporters. The campaign tracking and progress visualization tools make it easy to communicate impact to our board and major donors. Highly recommended for any nonprofit.',
                'rating' => 5.0,
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'donor_name' => 'Jennifer Thompson',
                'donor_title' => 'Founder & CEO, Clean Water Initiative',
                'content' => 'As a growing organization, we needed a scalable solution that could grow with us. This platform handles everything from small individual donations to major corporate partnerships seamlessly. The reporting capabilities are exceptional.',
                'rating' => 5.0,
                'is_featured' => true,
                'is_active' => true
            ],
            [
                'donor_name' => 'David Park',
                'donor_title' => 'Finance Manager, Hope For Tomorrow',
                'content' => 'The financial tracking and compliance features give us complete confidence in our donation management. The integration with our accounting systems and the detailed audit trails make year-end reporting a breeze.',
                'rating' => 4.8,
                'is_featured' => false,
                'is_active' => true
            ],
            [
                'donor_name' => 'Lisa Anderson',
                'donor_title' => 'Program Director, Community Outreach Network',
                'content' => 'What impressed me most is how user-friendly the system is for our volunteers. They can easily access donor information and track interactions without extensive training. The mobile responsiveness is perfect for our field work.',
                'rating' => 4.9,
                'is_featured' => false,
                'is_active' => true
            ],
            [
                'donor_name' => 'Robert Wilson',
                'donor_title' => 'Board Chair, Environmental Action Fund',
                'content' => 'The campaign management tools have helped us launch more successful fundraising initiatives. Being able to track progress in real-time and adjust our strategies accordingly has significantly improved our results.',
                'rating' => 4.7,
                'is_featured' => false,
                'is_active' => true
            ]
        ];

        foreach ($testimonials as $testimonialData) {
            Testimonial::create($testimonialData);
        }

        // Create sample contact messages from interested organizations
        $contactMessages = [
            [
                'name' => 'Amanda Foster',
                'email' => 'amanda.foster@youthfoundation.org',
                'organization' => 'Youth Foundation',
                'subject' => 'Demo Request',
                'message' => 'We are a growing youth development organization looking to upgrade our donation management system. Would love to schedule a demo to see how your platform could help us better serve our community.',
                'status' => 'new'
            ],
            [
                'name' => 'Carlos Martinez',
                'email' => 'carlos@animalrescue.org',
                'organization' => 'Animal Rescue Network',
                'subject' => 'Pricing Information',
                'message' => 'We are an animal rescue organization that processes about 200 donations per month. Can you provide pricing information for organizations of our size?',
                'status' => 'replied'
            ],
            [
                'name' => 'Dr. Rachel Green',
                'email' => 'rgreen@medicalaid.org',
                'organization' => 'International Medical Aid',
                'subject' => 'Migration Assistance',
                'message' => 'We currently use an outdated system and need to migrate approximately 5,000 donor records and 3 years of donation history. Do you provide migration services?',
                'status' => 'read'
            ]
        ];

        foreach ($contactMessages as $messageData) {
            ContactMessage::create($messageData);
        }

        // Update existing campaigns to approved status
        Campaign::query()->update([
            'approval_status' => 'approved',
            'created_by' => $adminUser->id,
            'approved_by' => $adminUser->id,
            'approved_at' => now(),
        ]);
    }
}
