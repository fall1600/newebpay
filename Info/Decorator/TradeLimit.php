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

    /**
     * @param InfoInterface $info
     * @param int $limit
     */
    public function __construct($info, $limit = 0)
    {
        parent::__construct();
        $this->info = $info;

        $this->setLimit($limit);
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'TradeLimit' => $this->limit,
            ];
    }

    /**
     * @param int $limit
     */
    protected function setLimit($limit)
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
