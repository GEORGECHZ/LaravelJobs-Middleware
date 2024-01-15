<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('intentos_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('route');
            $table->boolean('access_granted');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('intentos_users');
    }
};
