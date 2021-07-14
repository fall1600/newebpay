<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;

class PayerEmailEditable extends InfoDecorator
{
    /** @var Info */
    protected $info;

    /** @var bool */
    protected $canEditEmail;

    public function __construct($info, $canEditEmail = true)
    {
        parent::__construct();
        $this->info = $info;

        $this->canEditEmail = $canEditEmail;
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'EmailModify' => $this->canEditEmail ? 1 : 0,
            ];
    }
}
