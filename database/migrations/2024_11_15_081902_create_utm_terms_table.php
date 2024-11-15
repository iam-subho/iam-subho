<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('utm_terms', function (Blueprint $table) {
            $table->id();
            $table->string('utm_term')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('utm_terms');
    }
};
