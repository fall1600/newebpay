<?php

namespace fall1600\Package\Newebpay\Info\Period\Decorator;

class ReturnUrl extends Webhook
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'ReturnURL' => $this->url,
            ];
    }
}
