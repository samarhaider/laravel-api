<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id')->nullable()->default(null);
            $table->string('username', 50)->unique();
            $table->string('email')->unique();
            $table->char('password', 60);
            $table->string('avatar')->nullable()->default(null);
            $table->string('firstname', 50)->nullable()->default(null);
            $table->string('surname', 50)->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->enum('gender', ['male', 'female'])->nullable()->default(null);
            $table->date('dob')->nullable()->default(null);
            $table->string('mobile', 30)->nullable()->default(null);
            $table->string('landline', 30)->nullable()->default(null);
            $table->string('emergency_contact_name', 50)->nullable()->default(null);
            $table->string('emergency_contact_relationship', 50)->nullable()->default(null);
            $table->string('emergency_contact_number', 30)->nullable()->default(null);
            $table->text('contraindications')->nullable()->default(null);
            $table->text('notes')->nullable()->default(null);
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
        Schema::dropIfExists('clients');
    }
}
