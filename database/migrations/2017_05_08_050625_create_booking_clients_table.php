<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_client', function (Blueprint $table) {
//            $table->uuid('id');
            $table->uuid('booking_id');
            $table->uuid('client_id');
            $table->boolean('paid')->default(0);
//            $table->text('notes')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();

//            $table->primary('id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_client');
    }
}
