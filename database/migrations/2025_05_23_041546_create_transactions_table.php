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
    $table->uuid('id')->primary(); // transfer_id
    $table->uuid('from_user_id');
    $table->uuid('to_user_id');
    $table->decimal('amount', 15, 2);
    $table->string('remarks')->nullable();
    $table->decimal('balance_before', 15, 2)->nullable();
    $table->decimal('balance_after', 15, 2)->nullable();
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
