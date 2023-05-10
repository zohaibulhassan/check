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
        Schema::create('users', function (Blueprint $table) {
           $table->id();
            $table->string('company_name')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('registration_no');
            $table->string('company_description')->default(null);
            $table->string('approval_key')->default(null);
            $table->string('zipcode')->nullable();
            $table->string('email')->unique();
            $table->string('password')->unique();
            $table->string('phone')->nullable();
            $table->enum('user_status', ['a','r','p'])->comment('a -> accept,r->reject,p->pending')->nullable();
            $table->enum('user_type', ['a','u'])->comment('a->admin,u->user')->nullable();
            $table->longText('address')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
