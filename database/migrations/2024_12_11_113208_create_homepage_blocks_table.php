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
        Schema::create('homepage_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['highlight_posts', 'category', 'html']);
            $table->boolean('is_visible')->default(true);
            $table->integer('order')->default(0);
            $table->json('settings')->nullable();
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
        Schema::dropIfExists('homepage_blocks');
    }
};
