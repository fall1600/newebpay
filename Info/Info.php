<?php

namespace fall1600\Package\Newebpay\Info;

use fall1600\Package\Newebpay\Contracts\InfoInterface;
use fall1600\Package\Newebpay\Contracts\OrderInterface;
use fall1600\Package\Newebpay\Contracts\PayerInterface;

abstract class Info implements InfoInterface
{
    /**
     * 要交給藍新處理金流的訂單
     * @var OrderInterface
     */
    protected $order;

    /**
     * 付款人資訊
     * @var PayerInterface
     */
    protected $payer;

    /**
     * 藍新金流商店代號
     * @var string
     */
    protected $merchantId;

    /**
     * 支付通知網址
     *  藍新背景告知系統支付明細的callback url
     * @var string
     */
    protected $notifyUrl;

    /**
     * Decorator
     *
     * @return array
     */
    abstract public function getInfo();

    /**
     * @param string $merchantId
     * @param string $notifyUrl
     * @param OrderInterface $order
     * @param PayerInterface $payer
     */
    public function __construct($merchantId, $notifyUrl, $order, $payer)
    {
        $this->order = $order;

        $this->payer = $payer;

        $this->merchantId = $merchantId;

        $this->notifyUrl = $notifyUrl;
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return PayerInterface
     */
    public function getPayer()
    {
        return $this->payer;
    }
}
