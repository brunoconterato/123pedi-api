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
use Drinking\Models\Category;
use Drinking\Models\Client;
use Drinking\Models\Order;
use Drinking\Models\OrderItem;
use Drinking\Models\Product;
use Drinking\Models\Retailer;
use Drinking\Models\StockItem;
use Drinking\Models\UnregisteredOrder;
use Drinking\Models\UnregisteredOrderItem;
use Drinking\Models\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Client::class, function(Faker\Generator $faker) {
    return[
        'phone' =>$faker->phoneNumber,
        'address' =>$faker->address,
        'city' =>$faker->city,
        'state' => $faker->state,
        'zipcode' => $faker->postcode
    ];
});

$factory->define(Retailer::class, function (Faker\Generator $faker) {
    return [
        'cnpj' => $faker->numberBetween(1000000,999999999),
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'city' =>$faker->city,
        'state' => $faker->state,
        'zipcode' => $faker->postcode
    ];
});

$factory->define(Order::class, function(Faker\Generator $faker){
   return [
       'client_id' => random_int(1,10),
       'retailer_id' => 1,
       'total' => rand(0.01,100.00),
       'status' => 'Pendente',
   ];
});

$factory->define(OrderItem::class, function(Faker\Generator $faker){
    return [
        'stockItem_id' => random_int(1, 200),
        'order_id' => random_int(1, 500),
        'price' => rand(1,10),
        'quantity' => random_int(1,10),
    ];
});

$factory->define(Product::class, function(Faker\Generator $faker){
    return [
        'category_id' => random_int(1, 4),
        'name' =>$faker->word,
        'description' => $faker->text(200),
        'manufacturer' => $faker->name,
        'brand' => $faker->name,
    ];
});

$factory->define(Category::class, function(Faker\Generator $faker) {
    $availableCategories = [
        'alcoolicos' => 'alcoolicos',
        'nao_aloolicos' => 'nao_aloolicos',
        'cigarros' => 'cigarros',
        'outros' => 'outros'
    ];

    return [
        'name' => $availableCategories[array_rand($availableCategories)]
    ];
});

$factory->define(StockItem::class, function(Faker\Generator $faker) {
    $price = rand(0.01,100.0);
    $min_selling_price = rand(0.01, $price);
    $cost_price = rand(0.01, $min_selling_price*0.9);
    $start_date = date('d-m-Y',1488412799);
    $end_date = date('d-m-Y',1514764799);

    return [
        'product_id' => random_int(1, 200),
        'retailer_id' => 1,
       'quantity' => random_int(1,10),
       'price' => $price,
       'min_selling_price' => $min_selling_price,
       'cost_price' => $cost_price,
       'expiration_date' => $faker->dateTimeBetween($start_date,$end_date),
   ];
});

$factory->define(UnregisteredOrder::class, function(Faker\Generator $faker){
    return [
        'retailer_id' => 1,
        'total' => rand(0.01,100.00),
        'status' => 'Pendente',

        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'street_adress' => $faker->address,
        'adress_line_2' => random_int(1,1000),
        'neighborhood' => $faker->word,
        'city' => $faker->city,
        'state' => $faker->state,
        'zipcode' => $faker->postcode,
        'email' => $faker->email,
        'lat_coordinate' => $faker->latitude,
        'long_coordinate' => $faker->longitude,
    ];
});

$factory->define(UnregisteredOrderItem::class, function(Faker\Generator $faker){
    return [
        'quantity' => random_int(1,10),
        'unregistered_order_id' => random_int(1, 2000),
        'stockItem_id' => random_int(1, 200)
    ];
});



