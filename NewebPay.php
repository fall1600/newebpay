<?php

namespace fall1600;

use fall1600\Constants\LangType;
use fall1600\Contracts\OrderInterface;

class NewebPay
{
    /** @var string */
    protected $urlTest = 'https://ccore.newebpay.com/MPG/mpg_gateway';

    /** @var string */
    protected $urlProduction = 'https://core.newebpay.com/MPG/mpg_gateway';

    /** @var string */
    protected $version = '1.5';

    /** @var bool */
    protected $isProduction = true;

    /** @var string */
    protected $hashIV;

    /** @var string */
    protected $hashKey;

    /** @var string */
    protected $merchantID;

    /** @var string */
    protected $langType;

    /**
     * 離線付款有效天數, 預設7天, 最長可支援180天
     *  用來計算參數 ExpireDate
     *
     * @var int
     */
    protected $validTTL;

    /**
     * 支付完成返回的商店網址
     *
     * @var string
     */
    protected $returnUrl;

    /**
     * 支付通知網址
     *  藍星背景告知系統支付明細的callback
     *
     * @var string
     */
    protected $notifyUrl;

    /**
     * 付款人電子信箱
     *  交易完成或付款完成, 僅用來通知付款人
     *
     * @var string
     */
    protected $email;

    /**
     * 商店取號網址
     *  消費者選擇離線付款後 藍星要redirect 的網址
     * @var string
     */
    protected $customerUrl;

    /**
     * 支付取消返回商店網址
     * @var
     */
    protected $clientBackUrl;

    /** @var OrderInterface */
    protected $order;

    public function setLangType(string $langType)
    {
        $this->langType = $langType;

        return $this;
    }

    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
    }

    public function setMerchantID(string $merchantID)
    {
        $this->merchantID = $merchantID;

        return $this;
    }
    
    public function setHashIV(string $hashIV)
    {
        $this->hashIV = $hashIV;

        return $this;
    }
    
    public function setHashKey(string $hashKey)
    {
        $this->hashKey = $hashKey;

        return $this;
    }

    public function setIsProduction(bool $isProduction)
    {
        $this->isProduction = $isProduction;

        return $this;
    }

    public function setVersion(string $version)
    {
        $this->version = $version;

        return $this;
    }

    public function setValidTTL(int $validTTL)
    {
        if ($validTTL <= 0) {
            throw new \LogicException('ttl must be large than 1');
        }

        if ($validTTL > 180) {
            throw new \LogicException('ttl must be less than or equal to 180');
        }

        $this->validTTL = $validTTL;

        return $this;
    }


    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    public function echoPage()
    {
        echo $this->generateCheckoutPage();
    }

    /**
     * @return string
     */
    public function generateCheckoutPage()
    {
        $url = $this->isProduction? $this->urlProduction: $this->urlTest;

        $tradeInfo = $this->countTradeInfo();

        $tradeSha = $this->countTradeSha($tradeInfo);

        return <<<EOT
        <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                </head>
                <body>
                    <form name="newebpay" id="newebpay" method="post" action={$url} style="display:none;">
                        <input type="text" name="MerchantID" value="{$this->merchantID}" type="hidden"/>
                        <input type="text" name="TradeInfo" value="{$tradeInfo}" type="hidden"/>
                        <input type="text" name="TradeSha" value="{$tradeSha}" type="hidden"/>
                        <input type="text" name="Version" value="{$this->version}" type="hidden"/>
                    </form>
                </bod>
            </html>
        EOT;
    }


    /**
     * 交易資料 AES 加密
     *
     * @return string
     */
    protected function countTradeInfo()
    {
        $payload = $this->buildPayload();

        return $this->createMpgEncrypt($payload);
    }

    /**
     * 交易資料 SHA256 加密
     *
     * @param string $tradeInfo
     * @return string
     */
    protected function countTradeSha(string $tradeInfo)
    {
        return strtoupper(
            hash(
                "sha256",
                "HashKey={$this->hashKey}&{$tradeInfo}&HashIV={$this->hashIV}"
            )
        );
    }

    protected function createMpgEncrypt ($parameter = '')
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
                    $this->hashIV)
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

    /**
     * @return string
     */
    protected function countExpireDate()
    {
        if (! $this->validTTL) {
            return '';
        }

        return date(
            'Ymd',
            mktime(
                0,
                0,
                0,
                date('m'),
                date('d') + $this->validTTL,
                date('Y')
            )
        );
    }

    /**
     * @return array
     */
    protected function buildPayload()
    {
        return [
            'MerchantID' => $this->merchantID,
            'RespondType' => 'JSON',
            'TimeStamp' => time(),
            'Version' => $this->version,
            'LangType' => $this->langType ?? LangType::ZH_TW,
            'MerchantOrderNo' => $this->order->getMerchantOrderNo(),
            'Amt' => $this->order->getAmt(),
            'ItemDesc' => $this->order->getItemDesc(),
            'ReturnURL' => $this->returnUrl ?? '',
            'NotifyURL' => $this->notifyUrl,
            'CustomerURL' => $this->customerUrl ?? '',
            'ClientBackURL' => $this->clientBackUrl ?? '',
            'ExpireDate' => $this->countExpireDate(),
            'Email' => $this->email,
        ];
    }
}
