<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('bill_type');
            $table->decimal('amount_paid', 10, 2);
            $table->decimal('amount_due', 10, 2);
            $table->string('description')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->string('status')->default('pending');
            $table->date('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
