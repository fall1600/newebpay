<?php

namespace fall1600\Info;

use fall1600\Constants\Version;

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
