<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.server_key'));

        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id;
        $trackingNumber = explode('-', $orderId)[0];
        $fraud = $notification->fraud_status;

        $shipment = Shipment::where('tracking_number', $trackingNumber)->first();
        if (!$shipment) {
            return response(['message' => 'Order not found'], 404);
        }

        $paymentStatus = null;

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $paymentStatus = 'pending';
                } else {
                    $paymentStatus = 'paid';
                }
            }
        } else if ($transaction == 'settlement') {
            $paymentStatus = 'paid';
        } else if ($transaction == 'pending') {
            $paymentStatus = 'pending';
        } else if ($transaction == 'deny') {
            $paymentStatus = 'failed';
        } else if ($transaction == 'expire') {
            $paymentStatus = 'failed';
        } else if ($transaction == 'cancel') {
            $paymentStatus = 'failed';
        }

        if ($paymentStatus) {
            $shipment->update(['payment_status' => $paymentStatus]);

            // Update associated payment record
            $payment = $shipment->payments()->where('payment_method', 'midtrans')->latest()->first();
            if ($payment) {
                $payment->update([
                    'payment_status' => $paymentStatus,
                    'notes' => 'Midtrans: ' . $type
                ]);
            }

            // Add tracking entry for successful payment
            if ($paymentStatus === 'paid') {
                $shipment->trackings()->create([
                    'status' => $shipment->status,
                    'description' => 'Pembayaran berhasil dikonfirmasi via Midtrans (' . $type . ').',
                    'checked_at' => now(),
                ]);
            }
        }

        return response(['message' => 'Notification processed successfully']);
    }
}
