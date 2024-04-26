<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_seksis', function (Blueprint $table) {
            $table->id();
            $table->string('users_id')->nullable();
            $table->string('roles_bidang_id')->nullable();
            // $table->foreignId('users_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('roles_bidang_id')->constrained('roles_bidangs')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name_seksi');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_seksis');
    }
};
