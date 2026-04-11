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
        Schema::create('activity_logs', function (Blueprint $user) {
            $user->id();
            $user->foreignId('user_id')->constrained()->onDelete('cascade');
            $user->string('action'); // e.g., 'borrow', 'return', 'create', 'update', 'delete'
            $user->string('model_type')->nullable(); // e.g., 'App\Models\Book'
            $user->unsignedBigInteger('model_id')->nullable();
            $user->text('description')->nullable();
            $user->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
