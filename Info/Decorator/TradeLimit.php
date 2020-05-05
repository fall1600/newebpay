<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;

class TradeLimit extends InfoDecorator
{
    /** @var Info */
    protected $info;

    /**
     * 交易限制秒數, 超過即交易失敗
     *  0: 不啟用
     *  1~60: 限制60秒
     *  上限 900 秒
     * @var int
     */
    protected $limit;

    public function __construct(Info $info, int $limit = 0)
    {
        $this->info = $info;

        $this->setLimit($limit);
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'TradeLimit' => $this->limit,
            ];
    }

    protected function setLimit(int $limit)
    {
        if (1 <= $limit && $limit <= 60) {
            $limit = 60;
        }

        if ($limit > 900) {
            $limit = 900;
        }

        $this->limit = $limit;
    }
}
