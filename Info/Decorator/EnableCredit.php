<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Contracts\QuickCreditInterface;
use fall1600\Package\Newebpay\Info\Info;

class EnableCredit extends Enable
{
    /** @var QuickCreditInterface|null */
    protected $quickCredit;

    public function __construct(Info $info, ?QuickCreditInterface $quickCredit = null)
    {
        parent::__construct($info);

        $this->quickCredit = $quickCredit;
    }

    public function getInfo()
    {
        $result = $this->info->getInfo() +
            [
                'CREDIT' => $this->isEnable? 1: 0,
            ];

        if ($this->quickCredit) {
            $result += [
                'TokenTerm' => $this->quickCredit->getTokenTerm(),
                'TokenTermDemand' => $this->quickCredit->getTokenTermDemand(),
            ];
        }

        return $result;
    }
}
