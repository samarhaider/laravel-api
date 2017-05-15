<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('session_type_id');
            $table->uuid('user_id')->nullable()->default(null);
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('finish_time');
            $table->boolean('cancelled')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');
            $table->foreign('session_type_id')->references('id')->on('session_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
