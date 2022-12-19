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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Image::class)->constrained()->onDelete('cascade');
            $table->timestamps();
            //$table->unique(array('user_id', 'image_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('likes');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');       
        
    }
};
