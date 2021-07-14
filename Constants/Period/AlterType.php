<?php

namespace fall1600\Package\Newebpay\Constants\Period;

class AlterType
{
    // 暫停授權
    const SUSPEND = 'suspend';

    // 終止委託
    // 終止委託後無法再次以[restart]進行啟用
    const TERMINATE = 'terminate';

    // 重新啟用已暫停授權, 於最近一期開始取授權
    // 訂期定額委託單暫停後再啟用總期數不變, 扣款時間將向後展延至期數滿期
    const RESTART = 'restart';
}
