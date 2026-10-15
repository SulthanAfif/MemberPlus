<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('phone', 20)->nullable()->index();
            $table->string('email')->nullable();
            $table->foreignId('tier_id')->nullable()->constrained('membership_tiers')->nullOnDelete();
            $table->integer('points_balance')->default(0);
            $table->unsignedInteger('lifetime_points')->default(0);
            $table->string('status', 20)->default('active');
            $table->timestamp('joined_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
