<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('client_id');
            $table->uuid('user_id')->nullable()->default(null);
            $table->longText('client_data');
            $table->string('description')->nullable()->default(null);
            $table->float('amount');
            $table->date('payment_date');
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
        Schema::dropIfExists('payments');
    }
}
