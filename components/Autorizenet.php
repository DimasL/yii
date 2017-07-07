<?php


namespace app\components;


use net\authorize\api\constants\ANetEnvironment;
use net\authorize\api\contract\v1\CreateTransactionRequest;
use net\authorize\api\contract\v1\CreditCardType;
use net\authorize\api\contract\v1\MerchantAuthenticationType;
use net\authorize\api\contract\v1\OrderType;
use net\authorize\api\contract\v1\PaymentType;
use net\authorize\api\contract\v1\TransactionRequestType;
use net\authorize\api\controller\CreateTransactionController;

class Autorizenet
{
    private $merchantAuthentication, $refId, $transactionRequestType, $paymentOne, $creditCard;
    public $transactionResult, $transactionOrder;

    public function __construct($isLive = false)
    {
        $this->setupAPIcredentials($isLive);
    }

    /**
     * Common setup for API credentials
     * @param bool $isLive
     */
    private function setupAPIcredentials($isLive = false)
    {
        $this->merchantAuthentication = new MerchantAuthenticationType();
        if($isLive){
            $this->merchantAuthentication->setName("7fA6eULE6J");
            $this->merchantAuthentication->setTransactionKey("63Eqtn88g6UEQ77C");
        } else {
            $this->merchantAuthentication->setName("6fHpg27WW");
            $this->merchantAuthentication->setTransactionKey("5hqA6T88Mv4X7w22");
        }
        $this->refId = 'ref' . time();
    }

    /**
     * Create the payment data for a credit card
     * @param $cardNumber string
     * @param $expirationDate string
     */
    public function createCreditCard($cardNumber, $expirationDate, $cardCode)
    {
        $this->creditCard = new CreditCardType();
        $this->creditCard->setCardNumber($cardNumber);
        $this->creditCard->setExpirationDate($expirationDate);
        $this->creditCard->setCardCode($cardCode);
        $this->paymentOne = new PaymentType();
        $this->paymentOne->setCreditCard($this->creditCard);

    }

    /**
     * Create a transaction
     * @param $amount
     * @param bool $testmode
     */
    public function createTransaction($amount, $order, $testmode = true)
    {
        $this->transactionOrder = new OrderType();
        $this->transactionOrder->setDescription($order['description']);
        $this->transactionOrder->setInvoiceNumber($order['invoiceNumber']);

        $this->transactionRequestType = new TransactionRequestType();
        $this->transactionRequestType->setTransactionType("authCaptureTransaction");
        $this->transactionRequestType->setAmount($amount);
        $this->transactionRequestType->setPayment($this->paymentOne);
        $this->transactionRequestType->setOrder($this->transactionOrder);

        $request = new CreateTransactionRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($this->refId);
        $request->setTransactionRequest($this->transactionRequestType);
        $controller = new CreateTransactionController($request);
        if ($testmode) {
            $this->transactionResult = $controller->executeWithApiResponse(ANetEnvironment::SANDBOX);
        } else {
            $this->transactionResult = $controller->executeWithApiResponse(ANetEnvironment::PRODUCTION);
        }
    }

    /**
     * Get transaction errors
     * @return array|null
     */
    public function getErrors()
    {
        if ($this->transactionResult != null) {
            $tresponse = $this->transactionResult->getTransactionResponse();
            if (is_null($tresponse)) {
                echo "Charge Credit Card ERROR :  Invalid response";
            } elseif (!is_null($tresponse->getErrors())) {
                $errors = [];
                foreach ($tresponse->getErrors() as $error) {
                    $errors[] = ['errorCode' => $error->getErrorCode(), 'errorText' => $error->getErrorText()];
                }
                return $errors;
            }
        } else {
            echo "Charge Credit Card Null response returned";
        }
        return $tresponse->getErrors();
    }

    /**
     * Get transaction response
     */
    public function getResponse()
    {
        return $this->transactionResult->getTransactionResponse();
    }

    /**
     * Get transaction type info
     */
    public function getTransactionTypeInfo()
    {
        return [
          'transactionType'=>$this->transactionRequestType->getTransactionType(),
          'amount'=>$this->transactionRequestType->getAmount(),
        ];
    }

}