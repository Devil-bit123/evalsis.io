<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Cambiar la columna idTeacher a unsignedBigInteger
            $table->unsignedBigInteger('idTeacher')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Cambiar la columna idTeacher de nuevo (ajusta el tipo según sea necesario)
            $table->integer('idTeacher')->change();
        });
    }
}
