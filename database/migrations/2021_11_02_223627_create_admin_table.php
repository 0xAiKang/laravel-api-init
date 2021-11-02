<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateAdminTable
 */
class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id("admin_id");
            $table->string('username');
            $table->string('password');
            $table->string('mobile');
            $table->string('avatar');
            $table->integer('role_id');
            $table->tinyInteger('is_enable');
            $table->tinyInteger('is_root');
            $table->timestamps();
        });

        \App\Models\AdminModel::create([
            "admin_id" => 1,
            "username" => "admin",
            "password" => '$2y$10$Rj2RYJnvqrQxnZXcOTyq..4xpl1hAI2pNPAHIbJ7Ek1Qvj8Sj73uO',
            "mobile"   => 13886969091,
            "avatar"   => "https://cdn.jsdelivr.net/gh/0xAiKang/CDN/blog/images/avatar.jpg",
            "is_enable" => true,
            "is_root"   => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
