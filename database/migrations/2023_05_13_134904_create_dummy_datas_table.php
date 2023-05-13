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
        Schema::create('dummy_datas', function (Blueprint $table) {
            $table->id();
            $table->string('CompanyId')->nullable();
            $table->string('Company')->nullable();
            $table->string('SharedCompanyid')->nullable();
            $table->string('SharedCompanyname')->nullable();
            $table->string('Percentage')->nullable();
            $table->string('NoShares')->nullable();
            $table->string('Regnumber')->nullable();
            $table->string('StockYear')->nullable();
            $table->string('StockYearSpan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dummy_datas');
    }
};
