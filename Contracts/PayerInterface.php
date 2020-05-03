<?php

namespace fall1600\Package\Newebpay\Contracts;

interface PayerInterface
{
    /**
     * 用來通知付款人的信箱, 發生於完成交易或付款完成
     * @return string
     */
    public function getEmail();

    /**
     * 是否需要登入藍星金流會員
     * @return bool
     */
    public function getLoginType();
}
