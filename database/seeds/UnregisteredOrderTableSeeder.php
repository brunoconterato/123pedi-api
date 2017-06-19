<?php

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
        factory(UnregisteredOrder::class, 500)->create()->each(function ($o) {
            //Criando itens para orders
            //Cada orders 4 itens
            for($i=0; $i<=4; $i++){
                $o->items()->save(factory(UnregisteredOrderItem::class)->make());
            }
        });
    }
}
