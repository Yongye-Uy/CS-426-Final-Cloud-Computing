<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Campaign;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Process dummy credit card payment
     */
    public function processCreditCard(Request $request)
    {
        try {
            $request->validate([
                'donation_id' => 'required|exists:donations,id',
                'card_number' => 'required|string',
                'expiry' => 'required|string',
                'cvv' => 'required|string|size:3',
            ]);

            $donation = Donation::findOrFail($request->donation_id);

            if ($donation->status === 'completed') {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment already completed'
                ]);
            }

            // Strip spaces from card number
            $cardNumber = str_replace(' ', '', $request->card_number);

            // Simulate decline for test card 4000000000000002
            if ($cardNumber === '4000000000000002') {
                $donation->update(['status' => 'failed']);

                return response()->json([
                    'success' => false,
                    'message' => 'Card declined. Please try a different card.'
                ]);
            }

            // All other cards succeed
            DB::beginTransaction();

            $donation->update([
                'status' => 'completed',
                'notes' => ($donation->notes ?? '') . "\nPayment processed via credit card (dummy) at " . now()
            ]);

            $campaign = Campaign::find($donation->campaign_id);
            $campaign->increment('raised_amount', $donation->amount);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment successful! Thank you for your donation.',
                'transaction_id' => $donation->transaction_id
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            \Log::error('Credit card processing failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->except(['card_number', 'cvv'])
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error processing payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('=== DONATION ENDPOINT HIT ===');
        
        // Log the incoming request data for debugging
        \Log::info('Donation request received', [
            'request_data' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        try {
            $request->validate([
                'campaign_id' => 'required|exists:campaigns,id',
                'amount' => 'required|numeric|min:1',
                'donor_name' => 'required|string|max:255',
                'donor_email' => 'required|email',
                'message' => 'nullable|string',
                'anonymous' => 'nullable|in:0,1,true,false',
                'payment_method' => 'nullable|string|in:credit_card,online',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Donation validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Create or find donor
            $nameParts = explode(' ', $request->donor_name, 2);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

            $donor = Donor::firstOrCreate(
                ['email' => $request->donor_email],
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'donor_type' => 'individual',
                    'is_active' => true
                ]
            );

            // Create donation
            $donation = Donation::create([
                'donor_id' => $donor->id,
                'campaign_id' => $request->campaign_id,
                'amount' => $request->amount,
                'donation_date' => now(),
                'payment_method' => $request->payment_method ?? 'credit_card',
                'transaction_id' => 'TXN_' . strtoupper(uniqid()),
                'purpose' => 'Campaign Support',
                'notes' => $request->message,
                'status' => 'pending',
                'is_recurring' => false,
                'receipt_sent' => false
            ]);

            // Update campaign raised amount only if donation is completed
            if ($donation->status === 'completed') {
                $campaign = Campaign::find($request->campaign_id);
                $campaign->increment('raised_amount', $request->amount);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ($donation->status === 'pending') 
                    ? 'Donation created successfully. Please complete the payment to finalize your donation.'
                    : 'Thank you for your donation! Your contribution has been processed successfully.',
                'donation_id' => $donation->id,
                'transaction_id' => $donation->transaction_id,
                'status' => $donation->status
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            // Log the actual error for debugging
            \Log::error('Donation processing failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'There was an error processing your donation. Please try again.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Clean up abandoned donations that have been pending for too long
     * This can be called by a cron job or scheduled task
     */
    public function cleanupAbandonedDonations()
    {
        // Delete donations that have been pending for more than 2 hours
        $abandonedDonations = Donation::where('status', 'pending')
            ->where('created_at', '<', now()->subHours(2))
            ->get();

        foreach ($abandonedDonations as $donation) {
            \Log::info('Cleaning up abandoned donation', [
                'donation_id' => $donation->id,
                'amount' => $donation->amount,
                'created_at' => $donation->created_at,
                'donor_email' => $donation->donor->email ?? 'Unknown'
            ]);
            
            $donation->delete();
        }

        return response()->json([
            'success' => true,
            'message' => "Cleaned up {$abandonedDonations->count()} abandoned donations",
            'count' => $abandonedDonations->count()
        ]);
    }
}
