<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rewards')->insert(
            [
                'name'=>'Entradas de cine',
                'image'=>'https://empresas.blogthinkbig.com/wp-content/uploads/2019/06/Cinema-tickets-and-popcorn-illustration.jpg',
                'description'=> 'entradas de cine para una película de terror',
                'challenge_id'=> 1
            ]);
        
            DB::table('rewards')->insert(
                [
                    'name'=>'Cena',
                    'image'=>'https://empresas.blogthinkbig.com/wp-content/uploads/2019/06/Cinema-tickets-and-popcorn-illustration.jpg',
                    'description'=> 'entradas de cine para una película de terror',
                    'challenge_id'=> 1

                ]);

        
    }
}
