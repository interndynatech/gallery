<!-- new table -->
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_gallery', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('id_group', 100); // <--- Tambah
            $table->enum('type', ['training', 'exhibition', 'visit']);
            $table->string('title', 200); // <--- Optional: hadkan ke 200
            $table->string('image_path');
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        
            $table->foreign('client_id')->references('clientId')->on('clients')->onDelete('cascade');
        });

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_gallery');
    }
};
