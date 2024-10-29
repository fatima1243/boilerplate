<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('contact_no');
            $table->foreignId('state_id');
            $table->foreignId('city_id');
            $table->string('identity_card_front');
            $table->string('identity_card_back');
            $table->string('driving_lic_front');
            $table->string('driving_lic_back');
            $table->string('vehicle_insurance_policy'); 
            $table->string('vehicle_type'); 
            $table->string('vehicle_model'); 
            $table->string('year_of_production'); 
            $table->string('vehicle_plates'); 
            $table->string('driving_experience');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
}
