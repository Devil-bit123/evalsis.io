<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Cambiar la columna idStudent a unsignedBigInteger
            $table->unsignedBigInteger('idStudent')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            // Cambiar la columna idStudent de nuevo (ajusta el tipo según sea necesario)
            $table->integer('idStudent')->change();
        });
    }
}
