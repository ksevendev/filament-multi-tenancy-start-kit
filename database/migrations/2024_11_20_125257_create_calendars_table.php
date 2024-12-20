<?php

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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tenant::class)
                ->nullable();
            $table->foreignIdFor(User::class)
                ->nullable();
            $table->string('title');
            $table->text('description')
                ->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('color')
                ->nullable();
            $table->string('textColor')
                ->nullable();
            $table->string('url')
                ->nullable();
            $table->boolean('allDay')
                ->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
