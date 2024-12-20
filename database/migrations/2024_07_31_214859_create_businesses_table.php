<?php

use App\Models\Business\{Lead, Origins, Stages};
use App\Models\{Tenant, User};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tenant::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Lead::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Stages::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Origins::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name', 255)->nullable();
            $table->enum('status', ['missing', 'gain', 'running', 'pending'])->default('pending')->nullable();
            $table->decimal('valuation', $precision = 14, $scale = 2)->nullable();
            $table->boolean('new')->default(true);
            $table->boolean('active')->default(true);
            $table->dateTime('closing_forecast', $precision = 0)->nullable();
            $table->dateTime('closing_date', $precision = 0)->nullable();
            $table->dateTime('lost_at', $precision = 0)->nullable();
            $table->integer('order')->nullable();
            $table->json('vehicles')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
