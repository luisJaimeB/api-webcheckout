<?php

namespace App\Models;

use App\Constants\TransactionStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
    ];

    protected function payer(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
        );
    }

    public function isPending(): bool
    {
        return !empty($this->attributes['request_id'])
            && $this->attributes['transaction_status'] === TransactionStatus::PENDING;
    }

    public function couldPay(): bool
    {
        return empty($this->attributes['request_id'])
            || in_array($this->attributes['transaction_status'], [TransactionStatus::PENDING, TransactionStatus::CANCELED]);
    }

    public function isPaid(): bool
    {
        return $this->attributes['transaction_status'] === TransactionStatus::PAID;
    }

}
