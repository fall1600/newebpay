<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;

class PayCancel extends InfoDecorator
{
    /** @var Info */
    protected $info;

    /**
     * 支付取消返回的商店網址
     *
     * @var string
     */
    protected $clientBackUrl;

    public function __construct($info, $clientBackUrl = null)
    {
        parent::__construct();
        $this->info = $info;

        $this->setClientBackUrl($clientBackUrl);
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'ClientBackURL' => $this->clientBackUrl,
            ];
    }

    protected function setClientBackUrl($clientBackUrl = null)
    {
        $this->clientBackUrl = $clientBackUrl;
    }
}
