<?php

namespace fall1600\Package\Newebpay\Info\Period\Decorator;

use fall1600\Package\Newebpay\Info\Period\Info;

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

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'PeriodMemo' => $this->memo,
            ];
    }

    protected function setMemo(string $memo)
    {
        if (mb_strlen($memo) > 255) {
            throw new \LogicException("unsupported length of this memo $memo");
        }

        $this->memo = $memo;
    }
}
