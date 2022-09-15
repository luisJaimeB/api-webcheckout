<?php

use App\Constants\TransactionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 32)->unique();
            $table->unsignedBigInteger('request_id')->nullable();
            $table->decimal('total', 10, 2);
            $table->enum('transaction_status', TransactionStatus::toArray())->default(TransactionStatus::PENDING);
            $table->string('issuer_name')->nullable();
            $table->string('payment_method_name')->nullable();
            $table->date('date')->nullable();
            $table->timestamp('payment_expiration');
            $table->json('payer');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
