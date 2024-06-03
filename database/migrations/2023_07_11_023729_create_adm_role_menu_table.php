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
        Schema::create('adm_role_menu', function (Blueprint $table) {
            $table->id();
            $table->char('uuid');
            $table->unsignedBigInteger("role_id");
            $table->unsignedBigInteger("menu_id");
            $table->string("create_by")->nullable();
            $table->string("update_by")->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('adm_role')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('menu_id')->references('id')->on('adm_menu')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adm_role_menu');
    }
};
