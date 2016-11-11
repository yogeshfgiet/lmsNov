<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class UserTest extends TestCase
{

    /**
     * Initialize required params
     *
     * @return void
     */
    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Test the method to fetch billing info of User
     *
     * @return void
     */
    public function testGetBillingInfo()
    {
        $billingInfo = $this->userModel->getBillingInfo(TEST_USER_ID);

        $this->assertTrue(is_object($billingInfo));
    }

    /**
     * Test the method to fetch bank account info of User
     *
     * @return void
     */
    public function testGetBankAccountInfo()
    {
        $accountInfo = $this->userModel->getBankAccountInfo(TEST_USER_ID);

        $this->assertTrue(is_object($accountInfo));
    }

    /**
     * Test the method to fetch credit card info of User
     *
     * @return void
     */
    public function testGetCreditCardInfo()
    {
        $cardInfo = $this->userModel->getCreditCardInfo(TEST_USER_ID);

        $this->assertTrue(is_object($cardInfo));
    }
}
