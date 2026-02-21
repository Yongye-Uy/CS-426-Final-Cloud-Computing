<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'goal_amount',
        'raised_amount',
        'start_date',
        'end_date',
        'status',
        'image_url',
        'video_url',
        'created_by',
        'approval_status',
        'approved_by',
        'approved_at',
        'rejection_reason'
    ];

    protected $casts = [
        'goal_amount' => 'decimal:2',
        'raised_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime'
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->goal_amount == 0) return 0;
        return min(100, ($this->raised_amount / $this->goal_amount) * 100);
    }

    public function updateRaisedAmount()
    {
        $this->raised_amount = $this->donations()->where('status', 'completed')->sum('amount');
        $this->save();
    }

    public function getCampaignImage()
    {
        if ($this->image_url) {
            return $this->image_url;
        }

        // Default images based on campaign type/name
        $campaignImages = [
            'clean water' => 'https://images.unsplash.com/photo-1541544181051-e46607e4c29c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'education' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'healthcare' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'environment' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'emergency' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'youth' => 'https://images.unsplash.com/photo-1529390079861-591de354faf5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        ];

        $name = strtolower($this->name);
        foreach ($campaignImages as $keyword => $image) {
            if (strpos($name, $keyword) !== false) {
                return $image;
            }
        }

        // Default fallback image
        return 'https://images.unsplash.com/photo-1593113598332-cd288d649433?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
    }

    public function getVideoEmbedUrl()
    {
        if (!$this->video_url) {
            return null;
        }

        // Convert YouTube URLs to embed format
        if (strpos($this->video_url, 'youtube.com') !== false || strpos($this->video_url, 'youtu.be') !== false) {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches);
            if (isset($matches[1])) {
                return 'https://www.youtube.com/embed/' . $matches[1];
            }
        }

        // Convert Vimeo URLs to embed format
        if (strpos($this->video_url, 'vimeo.com') !== false) {
            preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches);
            if (isset($matches[1])) {
                return 'https://player.vimeo.com/video/' . $matches[1];
            }
        }

        return $this->video_url;
    }

    public function getVideoThumbnail()
    {
        if (!$this->video_url) {
            return $this->getCampaignImage();
        }

        // Get YouTube thumbnail
        if (strpos($this->video_url, 'youtube.com') !== false || strpos($this->video_url, 'youtu.be') !== false) {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches);
            if (isset($matches[1])) {
                return 'https://img.youtube.com/vi/' . $matches[1] . '/maxresdefault.jpg';
            }
        }

        return $this->getCampaignImage();
    }

    public static function getFeaturedCampaigns($limit = 4)
    {
        return static::where('status', 'active')
            ->where('approval_status', 'approved')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Approval methods
    public function approve($adminId)
    {
        $this->update([
            'approval_status' => 'approved',
            'approved_by' => $adminId,
            'approved_at' => now(),
            'status' => 'active'
        ]);
    }

    public function reject($adminId, $reason = null)
    {
        $this->update([
            'approval_status' => 'rejected',
            'approved_by' => $adminId,
            'approved_at' => now(),
            'rejection_reason' => $reason,
            'status' => 'cancelled'
        ]);
    }

    public function isPending()
    {
        return $this->approval_status === 'pending';
    }

    public function isApproved()
    {
        return $this->approval_status === 'approved';
    }

    public function isRejected()
    {
        return $this->approval_status === 'rejected';
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('approval_status', 'rejected');
    }
}
