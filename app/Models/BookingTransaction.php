<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'booking_trx_id',
        'name',
        'email',
        'phone',
        'proof',
        'post_code',
        'city',
        'is_paid',
        'address',
        'quantity',
        'total_amount',
        'sub_total_amount',
        'total_tax_amount'
    ];

    public static function generateUniqueTrxId()
    {
        $prefix = 'SHAYNA';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx_id', $randomString)->exists());
        return $randomString;
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetails::class);
    }
}
