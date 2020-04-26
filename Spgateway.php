<?php

namespace fall1600;

use GuzzleHttp\Client;

class Spgateway
{
    const URL_TEST = 'https://ccore.newebpay.com/MPG/mpg_gateway';

    const URL_PROD = 'https://core.newebpay.com/MPG/mpg_gateway';

    /** @var Client */
    protected $client;

    /** @var string */
    protected $hashIV;

    /** @var string */
    protected $hashKey;

    /** @var string */
    protected $merchantID;

    public function __construct(Client $client)
    {
        $this->client = $client;
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
    
    public function sendTransaction()
    {
        var_dump(
            $this->create_mpg_aes_encrypt(['foo' => 'bar'], $this->hashKey, $this->hashIV)
        );

        die;

        // send MerchantID, TradeInfo, TradeSha, Version
        try {
            $resp = $this->client
                ->request('post', self::URL_TEST, [
                    'MerchantID' => 'fall1600',
                    'TradeInfo' => '123',
                    'TradeSha' => '456',
                    'Version' => '1.5',
                ]);
            var_dump($resp->getBody()->getContents());
        } catch (\Throwable $exception) {
            var_dump($exception->getMessage());
        }
    }

    protected function create_mpg_aes_encrypt ($parameter = "" , $key = "", $iv = "") {
        $return_str = '';
        if (!empty($parameter)) {
//將參數經過 URL ENCODED QUERY STRING
            $return_str = http_build_query($parameter);
        }

        return trim(
            bin2hex(
                openssl_encrypt(
                    $this->addpadding($return_str),
                    'aes-256-cbc',
                    $key,
                    OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING,
                    $iv)
            )
        );
    }

    protected function addpadding($string, $blocksize = 32) {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }
}
