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
        Schema::create('adm_menu', function (Blueprint $table) {
            $table->id();
            $table->char('uuid');
            $table->string("induk");
            $table->string("kode_menu");
            $table->string("nama_menu");
            $table->string("icon");
            $table->string("urut");
            $table->string("route")->nullable();
            $table->string("remark");
            $table->string("create_by")->nullable();
            $table->string("update_by")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adm_menu');
    }
};
