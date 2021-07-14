<?php

namespace fall1600\Package\Newebpay;

use fall1600\Package\Newebpay\Exceptions\TradeInfoException;
use LogicException;

class Merchant
{
    use Cryption;

    /**
     * 藍新金流商店代號
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

    /**
     * 封裝來自藍新的回傳, 僅提供各種支付共同參數的accessor
     * @var Response
     */
    protected $response;

    public function __construct($id, $hashKey, $hashIv)
    {
        $this->id = $id;

        $this->hashKey = $hashKey;

        $this->hashIv = $hashIv;
    }

    /**
     * 因為商城代號, hashKey, hashIv 是一整組的, 要就一次修改
     * response 是屬於個別商城的, 改商城順手清空response
     * @param string $id
     * @param string $hashKey
     * @param string $hashIv
     * @return $this
     */
    public function reset($id, $hashKey, $hashIv)
    {
        $this->id = $id;
        $this->hashKey = $hashKey;
        $this->hashIv = $hashIv;

        $this->response = null;

        return $this;
    }

    /**
     * 注入來自藍新通知的交易資訊
     * @param array $rawData
     * @return $this
     * @throws TradeInfoException
     */
    public function setRawData($rawData)
    {
        if (isset($rawData['Period'])) {
            $this->response = new PeriodResponse(
                json_decode($this->removeCtrlChr($this->decryptPeriod($rawData['Period'])), true),
                $rawData['Period']);
        } else if (isset($rawData['TradeInfo'], $rawData['TradeSha'])) {
            $this->response = new TradeInfoResponse(
                json_decode($this->removeCtrlChr($this->decryptTradeInfo($rawData['TradeInfo'])), true),
                $rawData['TradeInfo'],
                $rawData['TradeSha']
            );
        } else {
            throw new TradeInfoException('invalid data');
        }
        return $this;
    }

    /**
     * 用來確認藍新通知的資料是否真的屬於此商城
     * @return bool
     */
    public function validateResponse()
    {
        if (!$this->response) {
            throw new LogicException('set rawData first');
        }
        if ($this->response instanceof TradeInfoResponse) {
            return $this->response->getTradeSha() === $this->countTradeSha($this->response->getTradeInfo());
        }
        if ($this->response instanceof PeriodResponse) {
            return true;
        }
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

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    private function removeCtrlChr($str)
    {
        return preg_replace('/[\x00-\x1F\x7F]/', '', $str);
    }
}
