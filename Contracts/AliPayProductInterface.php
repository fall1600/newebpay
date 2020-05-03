<?php

namespace fall1600\Package\Newebpay\Contracts;

interface AliPayProductInterface
{
    /**
     * 商品編號, 長度限制12位數
     * @return int
     */
    public function getProductId();

    /**
     * 商品名稱, 長度限制60個字元
     * @return string
     */
    public function getTitle();

    /**
     * 商品說明, 長度100個字元
     * @return string
     */
    public function getDescription();

    /**
     * 商品單價(新台幣), 長度限制5位數
     * @return int
     */
    public function getPrice();

    /**
     * 商品數量, 長度限制2位數
     * @return int
     */
    public function getQuantity();
}
