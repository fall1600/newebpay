<?php

namespace fall1600\Package\Newebpay\Contracts;

interface QuickCreditInterface
{
    /**
     * 付款人綁定資料
     *  可對應付款人之資料,用於綁定付款人與信用卡卡號時使用, 例:會員編號、Email
     *  限英、數字,「.」、「_」、「@」、「-」格式。
     * @return string
     */
    public function getTokenTerm();

    /**
     * 1: 必填信用卡到期日與末三碼
     * 2: 必填信用卡到期日
     * 3: 必填末三碼
     * @return int
     */
    public function getTokenTermDemand();
}
