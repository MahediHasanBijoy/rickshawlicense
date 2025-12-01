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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name')->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->string('category_slug')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->default('N/A');
            $table->text('description')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->timestamps();
        });


        DB::table('categories')->insert([
        'category_name' => 'বিশেষ কোটা',
        'category_slug' => 'special',
        'description'   => 'This is the default category.',
        'created_at'    => now(),
        'updated_at'    => now(),
    ]);
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
