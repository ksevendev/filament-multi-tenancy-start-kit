<?php

use App\Models\{Tenant, User};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('improvement_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tenant::class)
                ->nullable();
            $table->foreignIdFor(User::class)
                ->nullable();
            $table->enum('type', ['improvement', 'bug', 'feature'])
                ->default('improvement');
            $table->string('title');
            $table->text('description')
                ->nullable();
            $table->json('attachments')
                ->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed', 'running'])
                ->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('improvement_requests');
    }
};
