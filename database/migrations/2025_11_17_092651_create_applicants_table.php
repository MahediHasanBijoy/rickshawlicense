<?php

use App\Models\Area;
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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('application_number')->unique();
            $table->string('applicant_name')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('guardian_name')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('present_address')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('permanent_address')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('nid_no')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->unique();
            $table->string('bank_name')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('pay_order_no')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('amount')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default(0);
            $table->date('order_date');
            $table->date('applicaton_date')->nullable();
            $table->date('confirm_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('applicant_image');
            $table->string('signature_image')->nullable();
            $table->string('nid_image');
            $table->string('py_order_image');
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['pending', 'confirmed','selected','approved', 'expired','rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
