<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingTransactionRequest;

class BookingTransactionController extends Controller
{
    public function store(StoreBookingTransactionRequest $request){
        try {
            //code...
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error'   => $e->getMessage(), 500
            ]);
        }
    }
}
