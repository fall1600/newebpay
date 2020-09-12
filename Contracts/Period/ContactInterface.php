<?php

namespace fall1600\Package\Newebpay\Contracts\Period;

interface ContactInterface
{
    /**
     * 付款人電子信箱
     * @return string
     */
    public function getPayerEmail();

    /**
     * 設定於付款頁面,付款人電子信箱欄位是否開放讓付款人修改
     *  1=可修改
     *  0=不可修改
     * 當未提供此參數時,將預設為可修改
     * @return int
     */
    public function getPayerEmailModify();

    /**
     * 於付款人填寫此委託單時,是否需顯示付款人資訊填寫欄位
     *  Y=是
     *  N=否
     * 若未提供此參數,則預設為是
     * @return string
     */
    public function getPaymentInfo();

    /**
     * 於付款人填寫此委託單時,是否需顯示收件人資訊填寫欄位
     *  Y=是
     *  N=否
     * 若未提供此參數,則預設為是
     * @return string
     */
    public function getOrderInfo();
}
