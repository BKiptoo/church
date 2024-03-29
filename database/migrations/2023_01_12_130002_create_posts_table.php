<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('country_id');
            $table->uuid('category_id');
            $table->uuid('sub_category_id');
            $table->uuid('user_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->boolean('isFeatured')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('posts');
    }
};
