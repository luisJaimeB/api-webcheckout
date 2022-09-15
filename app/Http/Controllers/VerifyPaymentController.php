<?php

namespace App\Http\Controllers;

use App\Actions\PaymentRedirectionAction;
use App\Actions\VerifyPaymentStatusAction;
use App\Constants\PaymentStatus;
use App\Models\Transaction;
use App\Services\WebCheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyPaymentController extends Controller
{
    public function retry(WebCheckoutService $webCheckout, string $reference): JsonResponse
    {
        $transaction = Transaction::where('reference', $reference)
            ->whereIn('transaction_status', [PaymentStatus::PENDING, PaymentStatus::REJECTED])
            ->firstOrFail();

        return PaymentRedirectionAction::execute($webCheckout, $transaction);
    }

    public function verify(WebCheckoutService $webCheckout, string $reference): RedirectResponse
    {
        $transaction = Transaction::where('reference', $reference)
            ->whereNotNull('request_id')
            ->where('transaction_status', PaymentStatus::PENDING)
            ->firstOrFail();

        VerifyPaymentStatusAction::execute($webCheckout, $transaction);

        return redirect()->route('transactions.show', $transaction);
    }
}
