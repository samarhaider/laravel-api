<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasurementsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('client_id');
            $table->uuid('user_id')->nullable()->default(null);
            $table->float('bmi', 4, 2);
            $table->float('bmr', 4, 2);
            $table->float('body_fat', 5, 2);
            $table->float('calf', 4, 2);
            $table->float('chest', 5, 2);
            $table->float('height', 5, 2);
            $table->float('shoulders', 5, 2);
            $table->float('thigh', 5, 2);
            $table->float('upper_arm', 5, 2);
            $table->float('waist', 5, 2);
            $table->float('weight', 5, 2);
            $table->text('goals')->nullable()->default(null);
            $table->text('notes')->nullable()->default(null);
            $table->date('measurement_date');
            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('measurements');
    }
}
