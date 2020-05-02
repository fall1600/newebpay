<?php

namespace fall1600\Info;

abstract class Info
{
    /** @var string */
    protected $merchantId;

    /** @var string */
    protected $hashKey;

    /** @var string */
    protected $hashIv;

    /**
     * @return array
     */
    abstract public function getInfo();

    /**
     * @param string $merchantId 藍星金流商店代號
     * @param string $hashKey 商店專屬加密 hash key
     * @param string $hashIv 商店專屬加密 hash iv
     */
    public function __construct(string $merchantId, string $hashKey, string $hashIv)
    {
        $this->merchantId = $merchantId;

        $this->hashKey = $hashKey;

        $this->hashIv = $hashIv;
    }
}
