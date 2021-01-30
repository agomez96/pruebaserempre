<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->integer('cod')->unique();
            $table->string('name');
            $table->bigInteger('city');
            $table->foreign('city')->references('cod')->on('cities')->onDelete('Restrict')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::table('client')->insert(
            array(
                'cod' => '1121940481',
                'name' => 'Andrers Felipe Gomez',
                'city' => '50001'
            )
        );

        DB::table('client')->insert(
            array(
                'cod' => '42052430',
                'name' => 'Blanca Ruby Naranjo',
                'city' => '11001'
            )
        );

        DB::table('client')->insert(
            array(
                'cod' => '17313918',
                'name' => 'Hernando Gomez',
                'city' => '05001'
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
        Schema::dropIfExists('client');
    }
}
