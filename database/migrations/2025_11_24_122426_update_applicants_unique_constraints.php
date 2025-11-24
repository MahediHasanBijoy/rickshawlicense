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
        Schema::table('applicants', function (Blueprint $table) {
            $table->year('applicant_year')->after('applicaton_date');

            // 2. Drop old unique constraints
            $table->dropUnique(['nid_no']);   // was unique()
            $table->dropUnique(['phone']);    // was unique()

            // 3. Create new composite uniques
            $table->unique(['nid_no', 'applicant_year']);
            $table->unique(['phone', 'applicant_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            //
        });
    }
};
