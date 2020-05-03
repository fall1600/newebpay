<?php

namespace fall1600\Package\Newebpay\Info;

use fall1600\Package\Newebpay\Contracts\OrderInterface;
use fall1600\Package\Newebpay\Contracts\PayerInterface;

abstract class Info
{
    /**
     * 要交給藍星處理金流的訂單
     * @var OrderInterface
     */
    protected $order;

    /**
     * 付款人資訊
     * @var PayerInterface
     */
    protected $payer;

    /**
     * 藍星金流商店代號
     * @var string
     */
    protected $merchantId;

    /**
     * 支付通知網址
     *  藍星背景告知系統支付明細的callback url
     * @var string
     */
    protected $notifyUrl;

    /**
     * Decorator
     *
     * @return array
     */
    abstract public function getInfo();

    public function __construct(OrderInterface $order, PayerInterface $payer, string $merchantId, string $notifyUrl)
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
