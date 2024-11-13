<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_documents', function (Blueprint $table) {
            $table->id();
            $table->string('cnic_front');
            $table->string('cnic_back');
            $table->string('driving_license')->comment('Driving license image');
            $table->string('vehicle_insurance')->nullable()->comment('Vehicle Insurance license image');
            $table->foreignId('driver_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('legal_documents');
    }
}
