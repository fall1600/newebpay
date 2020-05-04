<?php

namespace fall1600\Package\Newebpay;

use fall1600\Package\Newebpay\Contracts\TradeInfoEncryptInterface;
use fall1600\Package\Newebpay\Info\Info;

class TradeInfoEncrypt implements TradeInfoEncryptInterface
{
    /** @var string */
    protected $hashKey;

    /** @var string */
    protected $hashIv;

    /**
     * @param Info $info
     * @return string
     */
    public function countTradeInfo(Info $info)
    {
        $infoRaw = $info->getInfo();

        return $this->createEncryptedStr($infoRaw);
    }

    /**
     * @param string $tradeInfo
     * @return string
     */
    public function countTradeSha(string $tradeInfo)
    {
        return strtoupper(
            hash(
                "sha256",
                "HashKey={$this->hashKey}&{$tradeInfo}&HashIV={$this->hashIv}"
            )
        );
    }

    public function setHashIv(string $hashIv)
    {
        $this->hashIv = $hashIv;

        return $this;
    }

    public function setHashKey(string $hashKey)
    {
        $this->hashKey = $hashKey;

        return $this;
    }

    protected function createEncryptedStr($parameter = '')
    {
        $returnStr = '';
        if (! empty($parameter)) {
            //將參數經過 URL ENCODED QUERY STRING
            $returnStr = http_build_query($parameter);
        }

        return trim(
            bin2hex(
                openssl_encrypt(
                    $this->addPadding($returnStr),
                    'aes-256-cbc',
                    $this->hashKey,
                    OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING,
                    $this->hashIv
                )
            )
        );
    }

    protected function addPadding(string $string, int $blockSize = 32)
    {
        $len = strlen($string);
        $pad = $blockSize - ($len % $blockSize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }
}
