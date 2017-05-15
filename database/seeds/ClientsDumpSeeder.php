<?php
use Illuminate\Database\Seeder;

class ClientsDumpSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Client::class, 10)->create()->each(function ($a) {
            
        });
    }
}
