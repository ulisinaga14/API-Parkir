<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parkir_id'); //foreign key yang berasal dari tabel parkir
            $table->string('no_plat');
            $table->enum('jenis',['motor','mobil']);
            $table->integer('slot')->nullable();
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
        Schema::dropIfExists('masuk');
    }
}
