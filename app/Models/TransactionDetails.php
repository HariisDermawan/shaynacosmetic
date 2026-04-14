<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetails extends Model
{
     use SoftDeletes;

     protected $fillable = [
        'quantity',
        'price',
        'booking_transaction_id',
        'cosmetic_id'
     ];

     public function bookingTransaction (): BelongsTo
     {
        return $this->belongsTo(BookingTransaction::class, 'booking_transaction_id');
     }

     public function cosmetic(): BelongsTo
     {
        return $this->belongsTo(cosmetic::class,'cosmetic_id');
     }
}
