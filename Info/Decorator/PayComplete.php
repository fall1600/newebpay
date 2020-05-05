<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;

class PayComplete extends InfoDecorator
{
    /** @var Info */
    protected $info;

    /**
     * 支付完成返回的商店網址
     *
     * @var string
     */
    protected $returnUrl;

    public function __construct(Info $info, string $returnUrl)
    {
        $this->info = $info;

        $this->setReturnUrl($returnUrl);
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'ReturnURL' => $this->returnUrl,
            ];
    }

    protected function setReturnUrl(string $returnUrl = null)
    {
        $this->returnUrl = $returnUrl;
    }
}
