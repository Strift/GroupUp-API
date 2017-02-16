<?php

use Illuminate\Database\Seeder;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert(['name' => 'League of Legends']);
        DB::table('games')->insert(['name' => 'Counter Strike: GO']);
        DB::table('games')->insert(['name' => 'Overwatch']);
        DB::table('games')->insert(['name' => 'DOTA2']);
    }
}
