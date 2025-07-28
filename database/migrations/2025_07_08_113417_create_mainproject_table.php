<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mainproject', function (Blueprint $table) {
            $table->id('mainProjectId'); // PK digunakan dalam controller
            $table->string('title');
            $table->text('introContent')->nullable();
            $table->text('desc')->nullable();
            $table->string('imagePath')->nullable();
            $table->dateTime('dateCreated')->nullable();
            $table->dateTime('dateModified')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mainproject');
    }
};
