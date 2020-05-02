<?php

namespace fall1600\Info;

class GeneralInfo extends Info
{
    public function getInfo()
    {
        return [
            'MerchantID' => $this->merchantId,
            'RespondType' => 'JSON',
            'TimeStamp' => time(),
            'Version' => '1.5',
        ];
    }
}
