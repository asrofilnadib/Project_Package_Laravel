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
        Schema::create('info_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nik_id');
            $table->unsignedBigInteger('lowongan_id');
            $table->foreign('nik_id')->references('id')->on('users');
            $table->foreign('lowongan_id')->references('id')->on('info_lowongan');
            $table->string('status');
            $table->dateTime('tanggal_interview');
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
