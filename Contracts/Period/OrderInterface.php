<?php

namespace fall1600\Package\Newebpay\Contracts\Period;

interface OrderInterface
{
    /**
     * 商店自訂的定期定額訂單編號
     * @return string
     */
    public function getMerOrderNo();

    /**
     * 委託金額
     *  1.純數字不含符號,例:1000
     *  2.幣別:新台幣
     * @return int
     */
    public function getAmount();

    /**
     * 產品名稱
     *  1.此委託單的商品或服務名稱
     *  2.長度限制為 100 字
     *  3.僅限制使用中文、英文、數字、空格及底線若內容必須含有特殊符號請自行轉為全形
     * @return string
     */
    public function getProdDesc();

    /**
     * 週期類別
     *  D=固定天期制, W=每週, M=每月, Y=每年
     * @return string
     */
    public function getPeriodType();

    /**
     * 交易週期授權時間
     *  W: 1~7
     *  M: 01~31
     *  Y: MMDD
     * @return string
     */
    public function getPeriodPoint();

    /**
     * 1. 此委託單執行信用卡授權交易的次數
     * 2. 若授權期數大於信用卡到期日,則系統自動以信用卡到期日為最終期數。
     *  例:授權週期為M(月),於2016/10/1建立委託單,授權期數為12,
     *     而付款人之信用卡到期月/年為12/16時,則此張委託單之授權期數為3,
     *     2016/10月、11月、12月,共3期。
     * @return string
     */
    public function getPeriodTimes();
}
