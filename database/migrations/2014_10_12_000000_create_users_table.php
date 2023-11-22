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
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('manager_id')->nullable()->constrained('users');
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->decimal('salary', 8, 2);
            $table->enum('role', [1, 2])->default(\App\Enums\RolesEnum::EMPLOYEE->value);
            $table->string('image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
