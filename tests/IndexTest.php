<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IndexTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        // $this->assertTrue(true);
        $this->visit('/')
         ->click('Register')
         ->seePageIs('/get-started-1');
        $this->visit('/')
          ->click('login')
          ->seePageIs('/login');
    }
}
