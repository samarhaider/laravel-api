<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
//            $table->increments('id');
            $table->uuid('id');
            $table->string('username', 50)->unique();
//            $table->string('name');
            $table->string('email')->unique();
            $table->char('password', 60);
            $table->string('avatar')->nullable()->default(null);
            $table->string('firstname', 50)->nullable()->default(null);
            $table->string('surname', 50)->nullable()->default(null);
//            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
