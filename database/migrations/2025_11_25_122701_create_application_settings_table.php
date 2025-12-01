<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->integer('license_year');
            $table->timestamps();
        });

        DB::table('application_settings')->insert([
        'application_fee'      => 200,
        'daily_fee'            => 20,
        'yearly_fee'           => 7300,
        'security_fee'         => 3000,
        'security_fee_refund'  => 2000,
        'app_expire_date'      => now()->endOfYear()->toDateString(),
        'license_year'         => now()->year,
        'created_at'           => now(),
        'updated_at'           => now(),
    ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_settings');
    }
};
