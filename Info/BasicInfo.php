<?php

namespace fall1600\Package\Newebpay\Info;

use fall1600\Package\Newebpay\Constants\Version;

class BasicInfo extends Info
{
    public function getInfo()
    {
        return [
            'MerchantID' => $this->merchantId,
            'RespondType' => 'JSON',
            'TimeStamp' => time(),
            'Version' => Version::CURRENT,
            'NotifyURL' => $this->notifyUrl,
        ];
    }
}
