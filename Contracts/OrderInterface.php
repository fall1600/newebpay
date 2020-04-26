<?php

namespace fall1600\Contracts;

interface OrderInterface
{
    /**
     * 交易金額
     *   1.純數字不含符號,例:1000。
     *   2.幣別:新台幣。
     * @return int
     */
    public function getAmt();

    /**
     * 商店訂單編號
     *
     * @return string
     */
    public function getMerchantOrderNo();
}
