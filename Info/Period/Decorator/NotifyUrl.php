<?php

namespace fall1600\Package\Newebpay\Info\Period\Decorator;

class NotifyUrl extends Webhook
{
    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'NotifyURL' => $this->url,
            ];
    }
}
