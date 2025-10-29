<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloodDonation extends Model
{
    protected $fillable = [
        'user_id',
        'donation_date',
        'blood_group',
        'units',
        'donation_center',
        'notes',
        'status'
    ];

    protected $casts = [
        'donation_date' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
