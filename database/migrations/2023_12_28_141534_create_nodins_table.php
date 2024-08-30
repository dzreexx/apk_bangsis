<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodins', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('no');
            $table->string('judul');
            $table->date('tanggal');
            $table->string('konseptor');
            $table->text('keterangan');
            $table->string('dokumen_nodin');
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
        Schema::dropIfExists('nodins');
    }
};
