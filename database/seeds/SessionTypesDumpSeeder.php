<?php
use Illuminate\Database\Seeder;

class SessionTypesDumpSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\SessionType::class, 10)->create()->each(function ($a) {
            
        });
    }
}
