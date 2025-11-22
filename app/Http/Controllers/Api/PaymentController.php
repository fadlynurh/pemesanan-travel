<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    // Customer: upload proof (FormData: booking_id, amount, method, proof file)
    public function uploadProof(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount'     => 'required|numeric|min:1',
            'proof'      => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        if ($booking->user_id != auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($request->amount != $booking->total_price) {
            return response()->json(['message' => 'Nominal tidak sesuai'], 422);
        }

        // Simpan file
        $path = $request->file('proof')->store('payments', 'public');

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount'     => $request->amount,
            'proof'      => $path,
            'status'     => 'pending',
        ]);

        return response()->json([
            'message' => 'Bukti pembayaran berhasil diupload',
            'payment' => $payment
        ], 201);
    }


    // Admin: confirm payment
    public function confirm($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'confirmed';
        $payment->confirmed_at = now();
        $payment->save();

        // update booking
        $booking = $payment->booking;
        $booking->status = 'paid';
        $booking->save();

        return response()->json(['message'=>'Payment confirmed','payment'=>$payment]);
    }
}
