<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('clients', function (Blueprint $table) {
        $table->id('clientId');
        $table->string('clientName');
        $table->string('clientType'); // eg: Majlis, Syarikat, etc
        $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
        $table->timestamps(); // includes created_at and updated_at
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
