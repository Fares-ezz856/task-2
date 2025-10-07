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
        Schema::create('applications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('contact_email');
        $table->string('contact_phone');
        $table->date('date_of_birth')->nullable();
        $table->enum('gender', ['male','female','other'])->nullable();
        $table->string('country')->nullable();
        $table->text('comments')->nullable();
        $table->json('files')->nullable(); // store array of file paths
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
