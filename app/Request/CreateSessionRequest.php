<?php

namespace App\Request;

use Illuminate\Http\Request;

class CreateSessionRequest extends GetInformationRequest
{
    public array $payment;
    public string $expiration;
    public string $returnUrl;

    public function __construct(array $data)
    {
        $this->payment = $data['payment'];
        $this->expiration = $data['expiration'];
        $this->returnUrl = $data['returnUrl'];
    }

    public static function url(?int $sessionId=null): string
    {
        return config('webcheckout.url') . '/api/session/' . $sessionId;
    }

    public function toArray()
    {
        return array_merge(parent::auth(), [
            'payment' => $this->payment,
            'expiration' => $this->expiration,
            'returnUrl' => $this->returnUrl,
            'ipAddress' => app(Request::class)->getClientIp(),
            'userAgent' => substr(app(Request::class)->header('User-Agent'), 0, 255)
        ]);
    }
}