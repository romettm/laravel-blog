<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Insert some stuff
        DB::table('categories')->insert([
           ['name' => 'Sport', 'slug' => 'sport'],
           ['name' => 'Vaba aeg', 'slug' => 'vabaaeg'],
           ['name' => 'Reisimine', 'slug' => 'reisimine'],
           ['name' => 'Tehnika', 'slug' => 'tehnika'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            //
        });
    }
}
