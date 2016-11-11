<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LandingPageTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testLandingPage()
    {
        $this->visit('/')
            ->see('Home')
            ->dontSee('Rails');
    }
}
