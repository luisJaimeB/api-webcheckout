<?php

namespace App\Services;

use App\Contracts\WebcheckoutContract;
use App\Models\Transaction;
use App\Request\CreateSessionRequest;
use App\Request\GetInformationRequest;
use Illuminate\Support\Facades\Http;

class WebCheckoutService implements WebcheckoutContract
{
    private array $data;

    public function getInformation(?int $session_id)
    {
        $getInformation = new GetInformationRequest();
        $data = $getInformation->auth();
        $url = $getInformation::url($session_id);

        return $this->request($data, $url);
    }

    public function buildData(Transaction $transaction): self
    {
        $this->data = [
            "payer" => $transaction->payer,
            "payment" => [
                "reference" => $transaction->reference,
                "description" => "Prueba de pago",
                "amount" => [
                    "currency" => "COP",
                    "total" => $transaction->total,
                ],
                "allowPartial" => false
            ],
            "expiration" => now()->addHours(12)->toIso8601String(),
            "returnUrl" => route('payments.verify', ['reference' => $transaction->reference])
        ];

        return $this;
    }

    public function createSession(): array
    {
        $createSessionRequest = new CreateSessionRequest($this->data);
        $data = $createSessionRequest->toArray();
        $url = $createSessionRequest::url();

        return $this->request($data, $url);
    }

    private function request(array $data, string $url)
    {
        $response = Http::post($url, $data);

        return $response->json();
    }
}