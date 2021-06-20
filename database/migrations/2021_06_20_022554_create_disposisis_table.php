<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposisis', function (Blueprint $table) {
            $table->id();
			$table->string('no_surat')->unique();
			$table->foreignId('dari_id')->constrained('users')->onDelete('cascade');
			$table->foreignId('kepada_id')->constrained('users')->onDelete('cascade');
			$table->foreignId('agenda_id')->constrained('agendas')->onDelete('cascade');
			$table->date('tanggal');
			$table->string('perihal');
			$table->string('file_surat')->nullable();
			$table->text('catatan')->nullable();
			$table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disposisis');
    }
}
