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
        Schema::create('application_settings', function (Blueprint $table) {
            $table->id();
            $table->float('application_fee', 8, 2);
            $table->float('daily_fee', 8, 2);
            $table->float('yearly_fee', 8, 2);
            $table->float('security_fee', 8, 2);
            $table->float('security_fee_refund', 8, 2);
            $table->date('app_expire_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_settings');
    }
};
