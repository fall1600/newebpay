<?php

namespace fall1600\Info;

abstract class Info
{
    /**
     * 藍星金流商店代號
     * @var string
     */
    protected $merchantId;

    /**
     * 商店專屬加密 hash key
     * @var string
     */
    protected $hashKey;

    /**
     * 商店專屬加密 hash iv
     * @var string
     */
    protected $hashIv;

    /**
     * 支付通知網址
     *  藍星背景告知系統支付明細的callback url
     * @var string
     */
    protected $notifyUrl;

    /**
     * @return array
     */
    abstract public function getInfo();

    public function __construct(string $merchantId, string $hashKey, string $hashIv, string $notifyUrl)
    {
        $this->merchantId = $merchantId;

        $this->hashKey = $hashKey;

        $this->hashIv = $hashIv;

        $this->notifyUrl = $notifyUrl;
    }
}
