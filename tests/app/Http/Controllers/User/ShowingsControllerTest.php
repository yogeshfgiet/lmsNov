<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowingsControllerTest extends TestCase
{
    /**
     * Testing index action
     *
     * @return void
     */
    public function testIndex()
    {
        //login to application as admin
        $this->loginAsAdmin();
        //going to index action
        $this->visit('/showings')
            ->assertViewHas('showings');

    }

    /**
     * Testing add action
     *
     * @return void
     */
    public function testAdd()
    {
        //login to application as admin
        $this->loginAsAdmin();
        ////going to index action
        $this->visit('/showings/add')
            ->assertViewHas(array('maxNoOfHouses', 'searchCriteria'));
    }

    /**
     * Testing view action
     *
     * @return void
     */
    public function testView()
    {
        //login to application as admin
        $this->loginAsAdmin();
        $this->post('/showings/view', ['id' => TEST_SHOWING_ID])
            ->assertTrue(true);
    }

    /**
     * Testing viewYourShowings action
     *
     * @return void
     */
    public function testViewYourShowings()
    {
        //login to application as admin
        $this->loginAsAdmin();
        $this->visit('/showings/view-your')
            ->see('Posted Showings')
            ->see('Accepted Showings');
    }

    /**
     * Testing viewYourShowings action
     *
     * @return void
     */
    public function testFeedbackForm()
    {
        //login to application as admin
        $this->loginAsAdmin();
        $this->post('/showings/feedback')
            ->see('Feedback');
    }

}
