<?php

namespace App\Actions;

use App\Models\Transaction;
use App\Services\WebCheckoutService;
use Illuminate\Support\Facades\Log;

class PaymentRedirectionAction
{
    public static function execute(WebCheckoutService $webCheckout, Transaction $transaction)
    {
        $response = $webCheckout->buildData($transaction)
            ->createSession();

        if (isset($response['requestId'])) {
            $transaction->update(['request_id'=> $response['requestId']]);
        }

        return response()->json($response);
    }
}
