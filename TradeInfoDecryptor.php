<?php

namespace fall1600\Package\Newebpay;

use fall1600\Package\Newebpay\Constants\Cipher;

class TradeInfoDecryptor
{
    /** @var string */
    protected $hashKey;

    /** @var string */
    protected $hashIv;

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

    public function strippadding($string)
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
}
