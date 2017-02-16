<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GamesSeederTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testHasGames()
    {
        $this->assertDatabaseHas('games', ['name' => 'League of Legends']);
        $this->assertDatabaseHas('games', ['name' => 'Counter Strike: GO']);
        $this->assertDatabaseHas('games', ['name' => 'Overwatch']);
        $this->assertDatabaseHas('games', ['name' => 'DOTA2']);
    }
}
