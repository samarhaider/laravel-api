<?php
/*
  |--------------------------------------------------------------------------
  | Model Factories
  |--------------------------------------------------------------------------
  |
  | Here you may define all of your model factories. Model factories give
  | you a convenient way to create models for testing and seeding your
  | database. Just tell the factory how a default model should look.
  |
 */

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
//        'password' => $password ?: $password = bcrypt('secret'),
        'password' => Hash::make('123456'),
        'avatar' => $faker->imageUrl(),
        'firstname' => $faker->firstName,
        'surname' => $faker->lastName,
    ];
});

$factory->define(App\Models\Client::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
//        'password' => $password ?: $password = bcrypt('secret'),
        'password' => Hash::make('123456'),
        'avatar' => $faker->imageUrl(),
        'firstname' => $faker->firstName,
        'surname' => $faker->lastName,
        'address' => $faker->address,
        'gender' => $faker->randomElement(array("male", "female")),
        'mobile' => $faker->phoneNumber,
        'landline' => $faker->phoneNumber,
        'dob' => $faker->date('Y-m-d', '-18 years'),
    ];
});

$factory->define(App\Models\SessionType::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->firstName,
        'duration' => $faker->randomFloat(2, 1.00, 300.99),
        'duration_unit' =>  $faker->randomElement(array('minute','hour')),
        'price' => $faker->randomFloat(2, 1.00, 300.99),
        'payable_per_duration' => $faker->boolean,
        'payable_per_person' => $faker->boolean,
        'deactivated' => $faker->boolean,
        'limited_to' => $faker->randomDigit,
    ];
});
