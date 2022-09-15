<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Constants\PaymentStatus;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\WebCheckoutService;
use Illuminate\Http\RedirectResponse;
use App\Actions\CreateTransactionAction;
use App\Actions\PaymentRedirectionAction;
use App\Actions\VerifyPaymentStatusAction;
use App\Http\Requests\CreatePaymentRequest;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function store(Request $request, WebCheckoutService $webCheckout)
    {
        $transaction = CreateTransactionAction::execute($request->all());

        return PaymentRedirectionAction::execute($webCheckout, $transaction);
    }
}
