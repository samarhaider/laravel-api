<?php
use Illuminate\Database\Seeder;

class UsersDumpSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 10)->create()->each(function ($a) {
            
        });
    }
}
