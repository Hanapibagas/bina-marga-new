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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('nama_penanggung_jawab');
            $table->string('nip_oprator');
            $table->string('pangakat');
            $table->foreignId('roles_bidang_id')->nullable()->constrained('roles_bidangs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('roles_seksi_id')->nullable()->constrained('roles_seksis')->onUpdate('cascade')->onDelete('cascade');
            $table->string('google_id')->nullable();
            $table->string('permission_edit');
            $table->string('permission_delete');
            $table->string('permission_upload');
            $table->string('permission_create');
            $table->string('permission_download');
            $table->string('picture')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
