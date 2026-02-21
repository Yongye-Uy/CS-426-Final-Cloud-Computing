<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'campaign_id',
        'amount',
        'donation_date',
        'payment_method',
        'transaction_id',
        'purpose',
        'notes',
        'status',
        'is_recurring',
        'recurring_frequency',
        'receipt_sent'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'donation_date' => 'date',
        'is_recurring' => 'boolean',
        'receipt_sent' => 'boolean'
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
