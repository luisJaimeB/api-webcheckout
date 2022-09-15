<?php

namespace App\Actions;

use App\Models\Transaction;
use Illuminate\Support\Str;

class CreateTransactionAction
{
    public static function execute(array $data): Transaction
    {
        $transaction = new Transaction();
        $transaction->reference = self::generateReference();
        $transaction->total = $data['total'];
        $transaction->payer = json_encode($data['payer']);
        $transaction->payment_expiration = now()->addHours(12);
        $transaction->save();

        return $transaction;
    }

    private static function generateReference(): string
    {
        do {
            $reference = null;
            $temporaryReference = date('ymd') . strtoupper(Str::random(6));

            if (!Transaction::where('reference', $temporaryReference)->exists()) {
                $reference = $temporaryReference;
            }
        } while (is_null($reference));

        return $reference;
    }
}