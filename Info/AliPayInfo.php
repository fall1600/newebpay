<?php

namespace fall1600\Package\Newebpay\Info;

abstract class AliPayInfo extends Info
{
    /**
     * 商品數量, 舉例此訂單有商品A, B兩種品項, 則帶入數值2
     * @var int $count
     */
    protected $count;

    /**
     * @param string $merchantId
     * @param string $notifyUrl
     * @param OrderInterface $order
     * @param AliPayPayerInterface $payer
     * @param int $count
     */
    public function __construct(
        $merchantId,
        $notifyUrl,
        $order = null,
        $payer = null,
        $count = 0
    )
    {
        parent::__construct($merchantId, $notifyUrl, $order, $payer);

        $this->count = $count;
    }
}
