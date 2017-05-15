<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionTypesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_types', function (Blueprint $table) {
            $table->uuid('id');
//            $table->increments('session_id');
            $table->uuid('user_id')->nullable()->default(null);
            $table->string('name');
            $table->float('duration');
            $table->enum('duration_unit', ['minute', 'hour']);
            $table->float('price');
            $table->boolean('payable_per_duration');
            $table->boolean('payable_per_person');
            $table->boolean('deactivated');
            $table->integer('limited_to');
            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_types');
    }
}
