<?php namespace App\Models;

use AuthorizeNetCustomer;
use AuthorizeNetCIM;
use AuthorizeNetPaymentProfile;
use Mockery\Exception;

class AuthorizeNet {

    /*
      |--------------------------------------------------------------------------
      | AuthorizeNet Model
      |--------------------------------------------------------------------------
      |
      | This Model will interact with Authrize.Net
      | It will handle the customer payments using Authorize.Net
      |
     */

    public $authNetRequest;

    /**
     * Create a new authentication controller instance.
     * @return void
     */
    public function __construct()
    {
        //defining authorize.net configs
        // @formatter:off
        defined('AUTHORIZENET_API_LOGIN_ID') ? AUTHORIZENET_API_LOGIN_ID :
            define("AUTHORIZENET_API_LOGIN_ID", config('custom.authorize_net_api_key'));

        defined('AUTHORIZENET_TRANSACTION_KEY') ? AUTHORIZENET_TRANSACTION_KEY :
            define("AUTHORIZENET_TRANSACTION_KEY", config('custom.authorize_net_transaction_key'));

        defined('AUTHORIZENET_SANDBOX') ? AUTHORIZENET_SANDBOX :
            define("AUTHORIZENET_SANDBOX", config('custom.authorize_net_sandbox'));

        // @formatter:on
        $this->authNetRequest = new AuthorizeNetCIM;
    }

    /**
     * Create create account type in string
     *
     * @param accountType in string
     *
     * @return string accountTypeStr;
     */
    protected function getAccountTypeInString($accountType)
    {

        //Finding account type string
        if ('2' === $accountType)
        {
            $accountTypeStr = 'businessChecking';
        }
        elseif ('1' === $accountType)
        {
            $accountTypeStr = 'checking';
        }
        else
        {
            $accountTypeStr = 'savings';
        }

        return $accountTypeStr;
    }

    /**
     * Create a new authentication controller instance.
     *
     * @param \Auth $userInfo    logged in users information
     * @param int $userType      type 1 or 2  or 3
     * @param array $paymentInfo payment information of user
     *
     * @return void
     */
    public function createCustomerProfile($userInfo, $userType, $paymentInfo)
    {
        $agentTypes = config('custom.agent_types');

        // Create new customer profile
        $customerProfile = new AuthorizeNetCustomer;
        $customerProfile->merchantCustomerId = $userInfo->id;
        $customerProfile->email = $userInfo->email;

        //for posting agents, add credit card info
        if (($userType == $agentTypes['posting']) ||
            ($userType == $agentTypes['both_posting_showing'])
        )
        {
            // Add payment profile.
            $paymentProfile = new AuthorizeNetPaymentProfile;
            $paymentProfile->payment->creditCard->cardNumber =
                $paymentInfo['card_number'];
            $paymentProfile->payment->creditCard->expirationDate =
                $paymentInfo['expiry_year'] . "-" .
                $paymentInfo['expiry_month'];
            $paymentProfile->payment->creditCard->cardCode =
                $paymentInfo['cvv_number'];
            $customerProfile->paymentProfiles[] = $paymentProfile;
        }

        //for showing agents, add bank account info
        if (($userType == $agentTypes['showing']) ||
            ($userType == $agentTypes['both_posting_showing'])
        )
        {

            // Adding another payment profile
            $paymentProfile2 = new AuthorizeNetPaymentProfile;
            $paymentProfile2->payment->bankAccount->accountType =
                $this->getAccountTypeInString($paymentInfo['account_type']);
            $paymentProfile2->payment->bankAccount->routingNumber =
                $paymentInfo['routing_number'];
            $paymentProfile2->payment->bankAccount->accountNumber =
                $paymentInfo['account_number'];
            $paymentProfile2->payment->bankAccount->nameOnAccount =
                $paymentInfo['account_name'];
            $paymentProfile2->payment->bankAccount->bankName =
                $paymentInfo['bank_name'];
            $customerProfile->paymentProfiles[] = $paymentProfile2;
        }

        $response =
            $this->authNetRequest->createCustomerProfile($customerProfile);

        //If data validated and added in authorize.net
        if ($response->isOk())
        {
            $authNetResponse['auth_net_customer_id'] =
                $response->getCustomerProfileId();

            //When user is both posting and showing agent
            if ($userType == $agentTypes['both_posting_showing'])
            {
                $paymentProfileIds = $response->getCustomerPaymentProfileIds();
                $authNetResponse['auth_net_card_payment_id'] =
                    $paymentProfileIds[0];
                $authNetResponse['auth_net_bank_account_id'] =
                    $paymentProfileIds[1];
            }
            elseif ($userType == $agentTypes['posting'])
            {
                $authNetResponse['auth_net_card_payment_id'] =
                    $response->getPaymentProfileId();
            }
            else
            {
                $authNetResponse['auth_net_bank_account_id'] =
                    $response->getPaymentProfileId();
            }

            $authNetResponse['status'] = TRUE;
        }
        else
        {
            $authNetResponse['status'] = FALSE;
            $authNetResponse['error_message'] = $response->getErrorMessage();
        }

        return $authNetResponse;
    }

    /**
     * Functionality to update users credit card profiles
     *
     * @param array $oldProfileInfo old payment information of user
     * @param array $newProfileInfo new payment information of user
     *
     * @return void
     */
    public function updateCustomerCreditCardProfile($oldProfileInfo,
        $newProfileInfo)
    {
        try
        {
            //WHen payment record exists
            if (isset($oldProfileInfo->auth_net_customer_id) &&
                (0 < $oldProfileInfo->auth_net_customer_id)
            )
            {
                //If data validated in authorize.net
                $paymentProfile = new AuthorizeNetPaymentProfile;
                $paymentProfile->payment->creditCard->cardNumber =
                    $newProfileInfo['card_number'];
                $paymentProfile->payment->creditCard->expirationDate =
                    $newProfileInfo['expiry_year'] . "-" .
                    $newProfileInfo['expiry_month'];
                $paymentProfile->payment->creditCard->cardCode =
                    $newProfileInfo['cvv_number'];

                //checking if to edit bank account info
                if (isset($oldProfileInfo->auth_net_card_payment_id) &&
                    (0 < $oldProfileInfo->auth_net_card_payment_id)
                )
                {
                    $response =
                        $this->authNetRequest->updateCustomerPaymentProfile($oldProfileInfo->auth_net_customer_id,
                            $oldProfileInfo->auth_net_card_payment_id,
                            $paymentProfile);
                }
                else
                {
                    //Creating a new payment profile id
                    $response =
                        $this->authNetRequest->createCustomerPaymentProfile($oldProfileInfo->auth_net_customer_id,
                            $paymentProfile);
                }

                //Checking response status
                if ($response->isOk())
                {
                    //Getting recent Id
                    $authNetResponse['auth_net_card_payment_id'] =
                        (0 < $oldProfileInfo->auth_net_card_payment_id) ?
                            $oldProfileInfo->auth_net_card_payment_id :
                            $response->getPaymentProfileId();

                    $authNetResponse['status'] = TRUE;
                }
                else
                {
                    $authNetResponse['status'] = FALSE;
                    $authNetResponse['error_message'] =
                        $response->getErrorMessage();

                    return $authNetResponse;
                }
            }
            else
            {
                $authNetResponse['status'] = FALSE;
                $authNetResponse['error_message'] = 'Profile does not exist';
            }
        } catch (Exception $e)
        {
            $authNetResponse['status'] = FALSE;
            $authNetResponse['error_message'] = $e->getMessage();
        }

        return $authNetResponse;
    }

    /**
     * Functionality to create / update users bank account profile
     *
     * @param array $oldProfileInfo old payment information of user
     * @param array $newProfileInfo new payment information of user
     *
     * @return void
     */
    public function updateCustomerBankAccountProfile($oldProfileInfo,
        $newProfileInfo)
    {
        try
        {
            //WHen payment record exists
            if (isset($oldProfileInfo->auth_net_customer_id) &&
                (0 < $oldProfileInfo->auth_net_customer_id)
            )
            {
                // Adding another payment profile
                $bankAccountProfile = new AuthorizeNetPaymentProfile;
                $bankAccountProfile->payment->bankAccount->accountType =
                    $this->getAccountTypeInString($newProfileInfo['account_type']);
                $bankAccountProfile->payment->bankAccount->routingNumber =
                    $newProfileInfo['routing_number'];
                $bankAccountProfile->payment->bankAccount->accountNumber =
                    $newProfileInfo['account_number'];
                $bankAccountProfile->payment->bankAccount->nameOnAccount =
                    $newProfileInfo['account_name'];
                $bankAccountProfile->payment->bankAccount->bankName =
                    $newProfileInfo['bank_name'];

                //checking if to edit bank account info
                if (isset($oldProfileInfo->auth_net_bank_account_id) &&
                    (0 < $oldProfileInfo->auth_net_bank_account_id)
                )
                {
                    $response =
                        $this->authNetRequest->updateCustomerPaymentProfile($oldProfileInfo->auth_net_customer_id,
                            $oldProfileInfo->auth_net_bank_account_id,
                            $bankAccountProfile);
                }
                else
                {
                    //Creating a new payment profile id
                    $response =
                        $this->authNetRequest->createCustomerPaymentProfile($oldProfileInfo->auth_net_customer_id,
                            $bankAccountProfile);
                }

                //Checking response status
                if ($response->isOk())
                {
                    //Getting recent Id
                    $authNetResponse['auth_net_bank_account_id'] =
                        (0 < $oldProfileInfo->auth_net_bank_account_id) ?
                            $oldProfileInfo->auth_net_bank_account_id :
                            $response->getPaymentProfileId();

                    $authNetResponse['status'] = TRUE;
                }
                else
                {
                    $authNetResponse['status'] = FALSE;
                    $authNetResponse['error_message'] =
                        $response->getErrorMessage();

                    return $authNetResponse;
                }
            }
            else
            {
                $authNetResponse['status'] = FALSE;
                $authNetResponse['error_message'] = 'Profile does not exist';
            }
        } catch (Exception $e)
        {
            $authNetResponse['status'] = FALSE;
            $authNetResponse['error_message'] = $e->getMessage();
        }

        return $authNetResponse;
    }
}
