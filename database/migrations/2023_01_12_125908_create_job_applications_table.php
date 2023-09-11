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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('career_id');
            $table->string('linkedInUrl')->nullable();
            $table->string('phoneNumber');
            $table->string('email');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('cv');
            $table->text('coverLetter');
            $table->boolean('isPassed')->default(false);
            $table->boolean('isClosed')->default(false);
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
        Schema::dropIfExists('job_applications');
    }
};
