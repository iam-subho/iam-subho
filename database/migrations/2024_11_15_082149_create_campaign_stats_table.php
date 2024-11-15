<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('campaign_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->nullable()->constrained('campaigns')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('utm_term_id')->nullable()->constrained('utm_terms')->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('monetization_timestamp');
            $table->decimal('revenue');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('campaign_stats');
    }
};
