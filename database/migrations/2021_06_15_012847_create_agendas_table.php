<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
			$table->date('tanggal_mulai');
			$table->date('tanggal_selesai')->nullable();
			$table->time('jam_mulai');
			$table->string('jam_selesai')->nullable();
			$table->string('kegiatan');
			$table->string('tempat');
			$table->string('pelaksana_kegiatan');
			$table->foreignId('disposisi');
			$table->string('undangan');
			$table->string('materi');
			$table->string('daftar_hadir');
			$table->string('notulen');
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
        Schema::dropIfExists('agendas');
    }
}
