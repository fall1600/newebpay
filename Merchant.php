<?php

namespace fall1600\Package\Newebpay;

use fall1600\Package\Newebpay\Constants\Cipher;
use fall1600\Package\Newebpay\Info\Info;

class Merchant
{
    /**
     * 藍星金流商店代號
     * @var string
     */
    protected $id;

    /**
     * 商店專屬 HashKey
     * @var string
     */
    protected $hashKey;

    /**
     * 商店專屬 HashIV
     * @var string
     */
    protected $hashIv;

    public function __construct(string $id, string $hashKey, string $hashIv)
    {
        $this->id = $id;

        $this->hashKey = $hashKey;

        $this->hashIv = $hashIv;
    }

    /**
     * 因為商城代號, hashKey, hashIv 是一整組的, 要就一次修改
     * @param  string  $id
     * @param  string  $hashKey
     * @param  string  $hashIv
     * @return $this
     */
    public function reset(string $id, string $hashKey, string $hashIv)
    {
        $this->id = $id;
        $this->hashKey = $hashKey;
        $this->hashIv = $hashIv;

        return $this;
    }

    /**
     * @param Info $info
     * @return string
     */
    public function countTradeInfo(Info $info)
    {
        $infoPayload = $info->getInfo();

        return $this->createEncryptedStr($infoPayload);
    }

    /**
     * @param string $tradeInfo
     * @return string
     */
    public function countTradeSha(string $tradeInfo)
    {
        if (! $tradeInfo) {
            throw new \LogicException('empty trade info');
        }

        return strtoupper(
            hash(
                "sha256",
                "HashKey={$this->hashKey}&{$tradeInfo}&HashIV={$this->hashIv}"
            )
        );
    }

    /**
     * 用來確認藍星通知的資料是否真的是此merchant 簽發的
     * @param  string  $tradeInfo
     * @param  string  $tradeSha
     * @return bool
     */
    public function validate(string $tradeInfo, string $tradeSha)
    {
        return $tradeSha === $this->countTradeSha($tradeInfo);
    }

    /**
     * 從藍星回傳的交易資訊
     * @param  string  $tradeInfo
     * @return bool|false|string
     */
    public function createAesDecrypt(string $tradeInfo)
    {
        if (! $tradeInfo) {
            throw new \LogicException('empty trade info');
        }

        return $this->stripPadding(
            openssl_decrypt(
                hex2bin($tradeInfo),
                Cipher::METHOD,
                $this->hashKey,
                OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING,
                $this->hashIv
            )
        );
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHashKey(): string
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

    protected function createEncryptedStr(array $infoPayload = [])
    {
        return trim(
            bin2hex(
                openssl_encrypt(
                    $this->addPadding(http_build_query($infoPayload)),
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

    protected function stripPadding($string)
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
