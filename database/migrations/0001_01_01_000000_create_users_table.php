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
            $table->foreignId('member_id')->nullable()->unique()->constrained('members')->onDelete('cascade');
            $table->foreignId('dependent_id')->nullable()->unique()->constrained('dependents')->onDelete('cascade');
            $table->string('nickname')->unique();
            $table->string('photo')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'management', 'member', 'dependent'])->default('member');
            $table->dateTime('last_login_at')->nullable()->default(null);
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
