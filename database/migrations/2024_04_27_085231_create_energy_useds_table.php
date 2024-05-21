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
        Schema::create('energy_useds', function (Blueprint $table) {
            $table->id();
            $table->float('KW')->default(0)->comment('none used for now');
            $table->foreignId('appliance_id')->constrained('appliances');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('energy_useds');
    }
};
