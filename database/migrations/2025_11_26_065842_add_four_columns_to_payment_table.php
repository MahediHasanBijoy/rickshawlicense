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
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('fee_paid', ['yes', 'no','paid'])->default('no')->after('fee');
            $table->float('security_payable',8,2)->default(0)->after('security_fee');
            $table->float('security_refundable',8,2)->default(0)->after('security_payable');
            $table->enum('security_paid', ['yes', 'no','paid'])->default('no')->after('security_payable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            //
        });
    }
};
