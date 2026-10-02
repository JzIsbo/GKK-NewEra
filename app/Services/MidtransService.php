<?php

namespace App\Services;

use App\Models\Persembahan;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    /**
     * Create Snap Token for payment
     */
    public function createSnapToken(Persembahan $persembahan): array
    {
        $params = [
            'transaction_details' => [
                'order_id'     => $persembahan->order_id,
                'gross_amount' => (int) $persembahan->nominal,
            ],
            'customer_details' => [
                'first_name' => $persembahan->nama_donatur ?: ($persembahan->user ? ($persembahan->user->nama_lengkap ?: $persembahan->user->name) : 'Donatur'),
                'email'      => $persembahan->email_donatur ?: ($persembahan->user ? $persembahan->user->email : null),
            ],
            'item_details' => [
                [
                    'id'       => $persembahan->jenis_persembahan_id,
                    'price'    => (int) $persembahan->nominal,
                    'quantity' => 1,
                    'name'     => $persembahan->jenisPersembahan->nama ?? 'Persembahan',
                ],
            ],
            'callbacks' => [
                'finish' => route('persembahan.success', $persembahan->order_id),
            ],
        ];

        $snapToken   = Snap::getSnapToken($params);
        $paymentUrl  = Snap::getSnapUrl($params);

        return [
            'snap_token'  => $snapToken,
            'payment_url' => $paymentUrl,
        ];
    }

    /**
     * Handle Midtrans webhook notification
     */
    public function handleNotification(): array
    {
        $notification     = new Notification();
        $orderId          = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus      = $notification->fraud_status;
        $paymentType      = $notification->payment_type;
        $transactionId    = $notification->transaction_id;

        $status = match (true) {
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => 'success',
            $transactionStatus === 'settlement'                           => 'success',
            $transactionStatus === 'pending'                              => 'pending',
            in_array($transactionStatus, ['deny', 'cancel', 'expire'])   => $transactionStatus === 'expire' ? 'expired' : $transactionStatus,
            default                                                       => 'pending',
        };

        return [
            'order_id'               => $orderId,
            'status'                 => $status,
            'payment_type'           => $paymentType,
            'midtrans_transaction_id'=> $transactionId,
        ];
    }
}
