<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contactus', function (Blueprint $table) {
            $table->id('contactId'); // Sesuai dengan controller
            $table->string('name');
            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['Pending', 'Done'])->default('Pending');
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contactus');
    }
};
