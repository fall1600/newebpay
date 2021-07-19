<?php

namespace fall1600\Package\Newebpay\Info\Close\Decorator;

use fall1600\Package\Newebpay\Info\Close\Info;

class Cancel extends Info
{
    /**
     * @var Info
     */
    protected $info;

    public function __construct(Info $info)
    {
        $this->info = $info;
    }

    public function getInfo()
    {
        return $this->info->getInfo() + [
            'Cancel' => 1,
        ];
    }
}
