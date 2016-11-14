<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 11/03/2016
 * Time: 14:54
 */

namespace AppBundle\Services;


class PaymentService
{
    private $amount;

    private $paymentId;

    private $paymentStatus;

    private  $paymentDate;

    private $reference;

    private $privateKey;

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @param mixed $paymentId
     */
    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;
    }

    /**
     * @return mixed
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * @param mixed $paymentStatus
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
    }

    /**
     * @return mixed
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @param mixed $paymentDate
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return mixed
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @param mixed $privateKey
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @return string
     */
    public function recreateSignature(){

       return strtoupper(md5( $this->amount . $this->reference . $this->paymentId . $this->paymentDate . $this->paymentStatus . $this->privateKey));

    }

    public function validationPayment($signature){
        $recreatedSignature=$this->recreateSignature();

        if ($recreatedSignature != $signature) {
            return false;
        } else {
            return true;
        }
    }

}