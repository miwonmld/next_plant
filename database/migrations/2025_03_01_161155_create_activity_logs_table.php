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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // create, update, delete
            $table->morphs('model'); // untuk menyimpan tipe model dan ID model
            $table->text('changes')->nullable(); // untuk menyimpan perubahan (misalnya pada update)
            $table->string('reason')->nullable(); // alasan untuk aksi
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
    
};
