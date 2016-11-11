<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Showings;

class ShowingsTest extends TestCase
{

    /**
     * Initialize required params
     *
     * @return void
     */
    public function __construct()
    {
        $this->showingModel = new Showings();
    }

    /**
     * Test the method to fetch All showings of User
     * that are shown on the map
     *
     * @return void
     */
    public function testGetAllShowingsForMap()
    {
        $showings = $this->showingModel->getAllShowingsForMap(TEST_USER_ID);

        $this->assertInternalType('array', $showings);
    }

    /**
     * Test the method to fetch user added showings
     *
     * @return void
     */
    public function testGetMyShowings()
    {
        $showings = $this->showingModel->getMyShowings(TEST_USER_ID);

        $this->assertInternalType('array', $showings);
    }

    /**
     * Test the method to fetch user added showings
     *
     * @return void
     */
    public function testGetShowingDetails()
    {
        $showingInfo = $this->showingModel->getShowingDetails(TEST_SHOWING_ID);

        $this->assertInternalType('array', $showingInfo);
    }

    /**
     * Test the method to fetch posting customer details
     *
     * @return void
     */
    public function testGetPostingCustomerDetails()
    {
        $showingInfo = $this->showingModel->getPostingCustomerDetails(TEST_SHOWING_ID);

        $this->assertInternalType('array', $showingInfo);
    }

    /**
     * Test the method to fetch houses of the showing
     *
     * @return void
     */
    public function testGetShowingWithHouses()
    {
        $showingInfo = $this->showingModel->getShowingWithHouses(TEST_SHOWING_ID, TEST_USER_ID);

        $this->assertInternalType('array', $showingInfo);
    }

    /**
     * Test the method to fetch complete showing info
     *
     * @return void
     */
    public function testGetCompleteShowingInfo()
    {
        $showingInfo = $this->showingModel->getCompleteShowingInfo(TEST_SHOWING_ID);

        $this->assertInternalType('array', $showingInfo);
    }

}
