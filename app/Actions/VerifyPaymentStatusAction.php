<?php

namespace App\Actions;

use App\Constants\InvoiceStatus;
use App\Constants\PaymentStatus;
use App\Constants\TransactionStatus;
use App\Models\Transaction;
use App\Services\WebCheckoutService;

class VerifyPaymentStatusAction
{
    public static function execute(WebCheckoutService $webCheckout, Transaction $transaction): void
    {
        $response = $webCheckout->getInformation($transaction->request_id);
        $status = isset($response['status'], $response['status']['status'])
            ? $response['status']['status']
            : null;

        if ($status && PaymentStatus::completed($status)) {
            $transaction->transaction_status = TransactionStatus::STATUS[$status];

            if ($transaction->isPaid()) {
                $transaction->issuer_name = $response['payment'][0]['issuerName'];
                $transaction->payment_method_name = $response['payment'][0]['paymentMethodName'];
                $transaction->date = $response['status']['date'];
            }
            $transaction->save();

            return;
        }

        if (now()->isAfter($transaction->payment_expiration)) {
            $transaction->invoice_status = TransactionStatus::CANCELED;
            $transaction->request_id = null;
            $transaction->save();
        }
    }
}
