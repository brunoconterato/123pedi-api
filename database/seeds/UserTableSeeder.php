<?php

use Drinking\Models\Client;
use Drinking\Models\Retailer;
use Drinking\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        print "Entrou UserTableSeeder::class";

        factory(User::class)->create([
            'name' => 'User',
            'role' => 'client',
            'email' => 'user@user.com',
            'password' => bcrypt(789456),
            'remember_token' => str_random(10),
        ])->client()->save(factory(Client::class)->make());

        print "\nCriou User";

//        factory(User::class)->create([
//            'name' => 'User2',
//            'role' => 'client',
//            'email' => 'user2@user.com',
//            'password' => bcrypt(789456),
//            'remember_token' => str_random(10),
//        ])->client()->save(factory(Client::class)->make());
//
//        print "\nCriou User2";

        factory(User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@user.com',
            'password' => bcrypt(789456),
            'role' => 'admin',
            'remember_token' => str_random(10),
        ])->client()->save(factory(Client::class)->make());

        print "\nCriou admin";

        factory(User::class)->create([
            'name' => 'retailer',
            'role' => 'retailer',
            'email' => 'retailer@user.com',
            'password' => bcrypt(789456),
            'remember_token' => str_random(10),
        ])->retailer()->save(factory(Retailer::class)->make());

        print "\nCriou retailer 1";

        factory(User::class)->create([
            'name' => 'retailer2',
            'role' => 'retailer',
            'email' => 'retailer2@user.com',
            'password' => bcrypt(789456),
            'remember_token' => str_random(10),
        ])->retailer()->save(factory(Retailer::class)->make());

        print "\nCriou retailer 2";

        factory(User::class)->create([
            'name' => 'retailer3',
            'role' => 'retailer',
            'email' => 'retailer3@user.com',
            'password' => bcrypt(789456),
            'remember_token' => str_random(10),
        ])->retailer()->save(factory(Retailer::class)->make());

        print "\nCriou retailer 3";

//        factory(User::class, 1)->create([
//            'role'=>'retailer'
//        ])->each(function($u){
//            $u->retailer()->save(factory(Retailer::class)->make());
//        });

//        factory(User::class, 10) ->create([
//            'role'=>'client'
//        ])->each(function($u){
//            $u->client()->save(factory(Client::class)->make());
//        });
    }
}