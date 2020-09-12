<?php

namespace fall1600\Package\Newebpay\Info\Period\Decorator;

class BackUrl extends Webhook
{
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'BackURL' => $this->url,
            ];
    }
}
