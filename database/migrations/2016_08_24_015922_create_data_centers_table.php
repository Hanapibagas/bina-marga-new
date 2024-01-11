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
        Schema::create('data_centers', function (Blueprint $table) {
            $table->id();
            $table->string('folder_name');
            $table->string('slug')->nullable();
            $table->foreignId('users_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('roles_bidang_id')->nullable()->constrained('roles_bidangs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('roles_seksi_id')->nullable()->constrained('roles_seksis')->onUpdate('cascade')->onDelete('cascade');
            $table->string('parent_name_id')->nullable();
            $table->integer('is_recycle')->default('1');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_centers');
    }
};
