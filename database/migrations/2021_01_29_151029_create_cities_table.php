<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->bigInteger('cod')->unique();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('cities')->insert(
            array(
                'cod' => '50001',
                'name' => 'Villavicencio'
            )
        );

        DB::table('cities')->insert(
            array(
                'cod' => '05001',
                'name' => 'Medellin'
            )
        );

        DB::table('cities')->insert(
            array(
                'cod' => '11001',
                'name' => 'Bogota'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
