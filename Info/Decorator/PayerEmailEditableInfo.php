<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;

class PayerEmailEditableInfo extends Info
{
    /** @var Info */
    protected $info;

    /** @var bool */
    protected $canEditEmail;

    public function __construct(Info $info, bool $canEditEmail = true)
    {
        $this->info = $info;

        $this->canEditEmail = $canEditEmail;
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'EmailModify' => $this->canEditEmail? 1: 0,
            ];
    }
}
