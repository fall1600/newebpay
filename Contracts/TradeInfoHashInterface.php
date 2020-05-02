<?php

namespace fall1600\Contracts;

use fall1600\Info\Info;

interface TradeInfoHashInterface
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
