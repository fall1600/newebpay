<?php

namespace fall1600\Package\Newebpay;

use fall1600\Package\Newebpay\Constants\Cipher;
use fall1600\Package\Newebpay\Contracts\InfoInterface;
use fall1600\Package\Newebpay\Exceptions\TradeInfoException;
use LogicException;

trait Cryption
{
    /**
     * @param InfoInterface $info
     * @return string
     */
    public function countTradeInfo($info)
    {
        $infoPayload = $info->getInfo();

        return $this->createEncryptedStr($infoPayload);
    }

    /**
     * @param string $tradeInfo
     * @return string
     */
    public function countTradeSha($tradeInfo)
    {
        if (!$tradeInfo) {
            throw new LogicException('empty trade info');
        }

        return strtoupper(
            hash(
                "sha256",
                "HashKey={$this->hashKey}&{$tradeInfo}&HashIV={$this->hashIv}"
            )
        );
    }

    /**
     * @return string
     */
    public function getHashKey()
    {
        return $this->hashKey;
    }

    /**
     * @return string
     */
    public function getHashIv()
    {
        return $this->hashIv;
    }

    public function createEncryptedStr($infoPayload = [])
    {
        return trim(
            bin2hex(
                openssl_encrypt(
                    $this->addPadding(http_build_query($infoPayload)),
                    Cipher::METHOD,
                    $this->hashKey,
                    OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
                    $this->hashIv
                )
            )
        );
    }

    /**
     * 從藍新回傳的加密交易資訊解成可讀的字串
     * @param string $tradeInfo
     * @return string
     * @throws TradeInfoException
     */
    public function decryptTradeInfo($tradeInfo)
    {
        if (!$tradeInfo) {
            throw new LogicException('empty trade info');
        }

        return $this->stripPadding(
            openssl_decrypt(
                hex2bin($tradeInfo),
                Cipher::METHOD,
                $this->hashKey,
                OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
                $this->hashIv
            )
        );
    }


    protected function addPadding($string, $blockSize = 32)
    {
        $len = strlen($string);
        $pad = $blockSize - ($len % $blockSize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    /**
     * @param $string
     * @return string
     * @throws TradeInfoException
     */
    protected function stripPadding($string)
    {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        }

        throw new TradeInfoException();
    }
}
