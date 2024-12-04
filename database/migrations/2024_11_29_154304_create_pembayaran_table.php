<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('kode_pembayaran'); // Primary Key
            $table->string('kode_pesanan'); // Foreign Key dari tabel pesanan
            $table->decimal('jumlah', 10, 2); // Total pembayaran
            $table->decimal('kembalian', 10, 2)->nullable(); // Kembalian
            $table->enum('metode', ['cash', 'debit', 'qr']); // Metode pembayaran
            $table->string('card_num')->nullable(); // Nomor kartu (untuk debit)
            $table->date('exp_date')->nullable(); // Tanggal kadaluarsa kartu (untuk debit)
            $table->string('zjp_code')->nullable(); // ZJP Code (untuk debit)
            $table->string('pin')->nullable(); // PIN (untuk debit)
            $table->boolean('authorized_debit')->nullable(); // Status otorisasi debit
            $table->string('qr_code')->nullable(); // URL atau path ke gambar QR (untuk QR)
            $table->boolean('authorized_qr')->nullable(); // Status otorisasi QR
            $table->timestamps();

            // Menambahkan Foreign Key untuk memastikan referensi ke tabel pesanan
            $table->foreign('kode_pesanan')->references('kode_pesanan')->on('pesanan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
