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
        Schema::create('info_lowongan', function (Blueprint $table) {
            $table->id();
            $table->string('posisi', 255);
            $table->string('divisi', 255);
            $table->text('deskripsi');
            $table->text('jobdesk');
            $table->text('syarat');
            $table->string('lokasi_penempatan', 255);
            $table->string('tipe_lamaran', 50);
            $table->boolean('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
