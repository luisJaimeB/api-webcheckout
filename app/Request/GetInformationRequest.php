<?php

namespace App\Request;

use App\Contracts\WebcheckoutRequestContract;

class GetInformationRequest implements WebcheckoutRequestContract
{
    private function nonce(): string
    {
        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }

        return $nonce;
    }

    public function auth(): array
    {
        $seed = date('c');
        $nonce = $this->nonce();
        $tranKey = base64_encode(sha1($nonce . $seed . config('webcheckout.secretKey'), true));

        return [
            'auth' => [
                'login' => config('webcheckout.login'),
                'tranKey' => $tranKey,
                'nonce' => base64_encode($nonce),
                'seed' => $seed
            ]
        ];
    }

    public static function url(?int $session_id): string
    {
        return config('webcheckout.url').'/api/session/'.$session_id;
    }
}