<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('service_type');
            $table->date('service_date');
            $table->string('service_duration');
            $table->text('additional_details');
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->double('pickup_lat')->nullable();
            $table->double('pickup_long')->nullable();
            $table->double('drop_lat')->nullable();
            $table->double('drop_long')->nullable();
            $table->float('distance');
            $table->boolean('is_assigned')->default(false);
            $table->foreignId('recruiter_id')->constrained()->cascadeOnDelete();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('job_posts');
    }
}
