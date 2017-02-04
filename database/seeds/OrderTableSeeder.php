<?php

use Drinking\Models\Order;
use Drinking\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Order::class, 50)->create()->each(function($o){
            //Criando itens para order
            //Cada order 4 itens
            for($i=0; $i<=4; $i++){
                $o->items()->save(factory(OrderItem::class)->make());
            }
        });
    }
}
