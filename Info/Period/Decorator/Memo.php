<?php

namespace fall1600\Package\Newebpay\Info\Period\Decorator;

use fall1600\Package\Newebpay\Info\Period\Info;
use LogicException;

class Memo extends Info
{
    /**
     * @var Info
     */
    protected $info;

    /**
     * @var string $memo
     */
    protected $memo;

    public function __construct(Info $info, string $memo)
    {
        $this->info = $info;

        $this->setMemo($memo);
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'PeriodMemo' => $this->memo,
            ];
    }

    /**
     * @param string $memo
     */
    protected function setMemo($memo)
    {
        if (mb_strlen($memo) > 255) {
            throw new LogicException("unsupported length of this memo $memo");
        }

        $this->memo = $memo;
    }
}
