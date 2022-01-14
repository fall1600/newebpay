<?php

namespace fall1600\Package\Newebpay\Info\Period\Decorator;

use fall1600\Package\Newebpay\Info\Period\Info;

abstract class Webhook extends Info
{
    /**
     * @var Info
     */
    protected $info;

    /**
     * @var string
     */
    protected $url;

    /**
     * @param InfoInterface $info
     * @param $url
     */
    public function __construct($info, $url)
    {
        $this->info = $info;

        $this->url = $url;
    }
}
