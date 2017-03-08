<?php

use Drinking\Models\Order;
use Drinking\Models\OrderItem;
use Drinking\Models\UnregisteredOrder;
use Drinking\Models\UnregisteredOrderItem;
use Illuminate\Database\Seeder;

class UnregisteredOrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UnregisteredOrder::class, 50)->create()->each(function($o){
            //Criando itens para order
            //Cada order 4 itens
            for($i=0; $i<=4; $i++){
                $o->items()->save(factory(UnregisteredOrderItem::class)->make());
            }
        });
    }
}
