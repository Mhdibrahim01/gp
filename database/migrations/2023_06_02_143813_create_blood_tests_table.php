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
        Schema::create('blood_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained()->cascadeOnDelete();
            $table->enum('hiv_result', ['positive', 'negative', 'indeterminate'])->nullable();
            $table->enum('hepatitis_b_result', ['positive', 'negative', 'indeterminate'])->nullable();
            $table->enum('hepatitis_c_result', ['positive', 'negative', 'indeterminate'])->nullable();
            $table->enum('syphilis_result', ['positive', 'negative', 'indeterminate'])->nullable();
            $table->enum('malaria_result', ['positive', 'negative', 'indeterminate'])->nullable();
            $table->string('note')->after('donation_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_tests');
    }
};
