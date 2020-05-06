<?php

namespace fall1600\Package\Newebpay;

use fall1600\Package\Newebpay\Constants\Cipher;
use fall1600\Package\Newebpay\Info\Info;

class TradeInfoHash
{
    /** @var string */
    protected $hashKey;

    /** @var string */
    protected $hashIv;

    public function __construct(string $hashKey = null, string $hashIv = null)
    {
        $this->hashKey = $hashKey;

        $this->hashIv = $hashIv;
    }

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

    public function createAesDecrypt($parameter = "")
    {
        return $this->strippadding(
            openssl_decrypt(
                hex2bin($parameter),
                Cipher::METHOD,
                $this->hashKey,
                OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING,
                $this->hashIv
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
                    Cipher::METHOD,
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

    protected function strippadding($string)
    {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }
    }
}
