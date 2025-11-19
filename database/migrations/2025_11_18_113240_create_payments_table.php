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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_no')->unique();
            $table->float('fee', 8, 2);
            $table->date('fee_date')->nullable();
            $table->float('yearly_fee', 8, 2)->default(0);
            $table->date('yearly_fee_date')->nullable();
            $table->float('security_fee', 8, 2)->default(0);
            $table->date('security_fee_date')->nullable();
            $table->float('yearly_fee_refund', 8, 2)->default(0);
            $table->float('security_fee_refund', 8, 2)->default(0);
            $table->float('total_paid', 8, 2)->default(0);
            $table->date('payment_date');
            $table->boolean('is_security_refund')->default(false);
            $table->boolean('is_yearly_fee_refund')->default(false);
            $table->foreignId('yearly_fee_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('security_fee_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('yearly_fee_refund_date')->nullable();
            $table->date('security_fee_refund_date')->nullable();
            $table->foreignId('yearly_fee_refund_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('security_fee_refund_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
