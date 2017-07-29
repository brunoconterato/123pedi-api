<?php

use Drinking\Models\OpenInterval;
use Drinking\Repositories\RetailerRepository;
use Illuminate\Database\Seeder;

class OpenIntervalTableSeeder extends Seeder
{
    /**
     * @var RetailerRepository
     */
    private $retailerRepository;

    public function __construct(RetailerRepository $retailerRepository){

        $this->retailerRepository = $retailerRepository;
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->retailerRepository->all() as $retailer){
            for($i = 0; $i<7; $i++){

                $openTimeSec = rand(1,86400);
                $closeTimeSec = rand($openTimeSec,86400);

                $openTime = date('H:i:s', $openTimeSec);
                $closeTime = date('H:i:s', $closeTimeSec);

                factory(OpenInterval::class)->create([
                    'retailer_id' => $retailer->id,
                    'day_of_week' => $i,
                    'open_time' => $openTime,
                    "close_time" => $closeTime
                ]);
            }
        }
    }
}
