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
        Schema::create('hafalans', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->unsignedBigInteger('id_surat');
            $table->unsignedBigInteger('id_siswa');
            $table->string('tahun_pelajaran');
            $table->string('semester');
            $table->string('kefasihan');
            $table->string('tajwid');
            $table->string('kelancaran');
            $table->string('capaian');
            $table->string('audio')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();

            $table->foreign('id_surat')->references('id')->on('surats')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hafalans');
    }
};
