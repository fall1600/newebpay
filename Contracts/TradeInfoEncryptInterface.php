<?php

namespace fall1600\Package\Newebpay\Contracts;

use fall1600\Package\Newebpay\Info\Info;

interface TradeInfoEncryptInterface
{
    /**
     * @param Info $info
     * @return string
     */
    public function countTradeInfo(Info $info);

    /**
     * @param string $tradeInfo
     * @return string
     */
    public function countTradeSha(string $tradeInfo);
}
