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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->onDelete('cascade');
            $table->string('method'); // transfer, qris
            $table->string('status')->default('pending'); // pending, paid, failed
            $table->decimal('amount', 12, 2);
            $table->text('bank_account')->nullable(); // untuk transfer: Nama Bank, No Rekening, Atas Nama
            $table->text('qris_code')->nullable(); // untuk QRIS: URL atau code
            $table->text('proof_image')->nullable(); // Bukti transfer
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
