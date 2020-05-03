<?php

namespace fall1600\Package\Newebpay\Contracts;

interface AliPayPayerInterface extends PayerInterface
{
    /**
     * 收貨人姓名
     * @return string
     */
    public function getReceiver();

    /**
     * 收貨人主要聯絡電話
     * @return string
     */
    public function getTel1();

    /**
     * 收貨人次要聯絡電話
     * @return string
     */
    public function getTel2();

    /**
     * 商品項次, 舉例此訂單有A, B 兩種商品品項, 則帶入2
     * @return int
     */
    public function getCount();
}
