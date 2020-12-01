<?php

namespace fall1600\Package\Newebpay;

use fall1600\Package\Newebpay\Contracts\OrderInterface;
use fall1600\Package\Newebpay\Exceptions\TradeInfoException;
use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\Period\Info as PeriodInfo;

class NewebPay
{
    /**
     * 藍新說是哪一版就是哪一版
     * @var string
     */
    public const VERSION = '1.5';

    /**
     * 付款-測試環境
     * @var string
     */
    public const CHECKOUT_URL_TEST = 'https://ccore.newebpay.com/MPG/mpg_gateway';

    /**
     * 付款-正式環境
     * @var string
     */
    public const CHECKOUT_URL_PRODUCTION = 'https://core.newebpay.com/MPG/mpg_gateway';

    /**
     * 查詢付款資訊-測試環境
     * @var string
     */
    public const QUERY_URL_TEST = 'https://ccore.newebpay.com/API/QueryTradeInfo';

    /**
     * 查詢付款資訊-正式環境
     * @var string
     */
    public const QUERY_URL_PRODUCTION = 'https://core.newebpay.com/API/QueryTradeInfo';

    /**
     * 建立定期定額委託單-測試環境
     * @var string
     */
    public const ISSUE_URL_TEST = 'https://ccore.newebpay.com/MPG/period';

    /**
     * 建立定期定額委託單-正式環境
     * @var string
     */
    public const ISSUE_URL_PRODUCTION = 'https://core.newebpay.com/MPG/period';

    /**
     * 修改已建立委託單狀態-測試環境
     * @var string
     */
    public const ALTER_STATUS_URL_TEST = 'https://ccore.newebpay.com/MPG/period/AlterStatus';

    /**
     * 修改已建立委託單狀態-正式環境
     * @var string
     */
    public const ALTER_STATUS_URL_PRODUCTION = 'https://core.newebpay.com/MPG/period/AlterStatus';

    /**
     * 修改已建立委託單內容-測試環境
     * @var string
     */
    public const ALTER_AMT_URL_TEST = 'https://ccore.newebpay.com/MPG/period/AlterAmt';

    /**
     * 修改已建立委託單內容-正式環境
     * @var string
     */
    public const ALTER_AMT_URL_PRODUCTION = 'https://core.newebpay.com/MPG/period/AlterAmt';

    /**
     * 決定URL 要使用正式或測試機
     * @var bool
     */
    protected $isProduction = true;

    /**
     * 送往藍新表單的id
     * @var string
     */
    protected $formId = 'newebpay-form';

    /** @var Merchant */
    protected $merchant;

    /**
     * aha: 雖然文件上 PeriodType(週期類別), PeriodPoint(交易週期授權時間) 標注選填, 但實際觸發發現是必填
     * @param string $orderNo 商店訂單編號
     * @param string $periodNo 委託單號
     * @param string $periodType 週期類別
     * @param string $periodPoint 交易週期授權時間
     * @param int|null $alterAmt 委託金額
     * @return array
     * @throws TradeInfoException
     */
    public function alterAmt(
        string $orderNo,
        string $periodNo,
        string $periodType,
        string $periodPoint,
        int $alterAmt = null
    ) {
        if (! $this->merchant) {
            throw new \LogicException('empty merchant');
        }

        $url = $this->isProduction? static::ALTER_AMT_URL_PRODUCTION: static::ALTER_AMT_URL_TEST;

        $data = [
            'RespondType' => 'JSON',
            'Version' => '1.0',
            'MerOrderNo' => $orderNo,
            'PeriodNo' => $periodNo,
            'TimeStamp' => time(),
            'PeriodType' => $periodType,
            'PeriodPoint' => $periodPoint,
        ];

        if ($alterAmt) {
            $data['AlterAmt'] = $alterAmt;
        }

        $payload = [
            'MerchantID_' => $this->merchant->getId(),
            'PostData_' => $this->merchant->createEncryptedStr($data),
        ];

        $resp = $this->post($url, $payload);
        if (! isset($resp['period'])) {
            throw new TradeInfoException("interface change from Newebpay");
        }

        return json_decode($this->merchant->decryptTradeInfo($resp['period']), true);
    }
    
    /**
     * @param string $orderNo
     * @param string $periodNo
     * @param string $alterType
     * @return array
     * @throws TradeInfoException
     */
    public function alterStatus(string $orderNo, string $periodNo, string $alterType)
    {
        if (! $this->merchant) {
            throw new \LogicException('empty merchant');
        }

        $url = $this->isProduction? static::ALTER_STATUS_URL_PRODUCTION: static::ALTER_STATUS_URL_TEST;

        $payload = [
            'MerchantID_' => $this->merchant->getId(),
            'PostData_' => $this->merchant->createEncryptedStr(
                [
                    'RespondType' => 'JSON',
                    'Version' => '1.0',
                    'MerOrderNo' => $orderNo,
                    'PeriodNo' => $periodNo,
                    'AlterType' => $alterType,
                    'TimeStamp' => time(),
                ]
            ),
        ];

        $resp = $this->post($url, $payload);
        if (! isset($resp['period'])) {
            throw new TradeInfoException("interface change from Newebpay");
        }

        return json_decode($this->merchant->decryptTradeInfo($resp['period']), true);
    }

    public function issue(PeriodInfo $info)
    {
        echo <<<EOT
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        {$this->generatePeriodForm($info)}
        <script>
            var form = document.getElementById("$this->formId");
            form.submit();
        </script>
    </bod>
</html>
EOT;
    }

    public function generatePeriodForm(PeriodInfo $info)
    {
        if (! $this->merchant) {
            throw new \LogicException('empty merchant');
        }

        $url = $this->isProduction? static::ISSUE_URL_PRODUCTION: static::ISSUE_URL_TEST;

        $tradeInfo = $this->merchant->countTradeInfo($info);

        return <<<EOT
<form name="newebpay" id="{$this->formId}" method="post" action="{$url}" style="display:none;">
    <input type="text" name="MerchantID_" value="{$this->merchant->getId()}" type="hidden"/>
    <input type="text" name="PostData_" value="$tradeInfo" type="hidden">
</form>
EOT;
    }

    public function checkout(Info $info)
    {
        echo <<<EOT
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        {$this->generateForm($info)}
        <script>
            var form = document.getElementById("$this->formId");
            form.submit();
        </script>
    </bod>
</html>
EOT;
    }

    /**
     * @param Info $info
     * @return string
     */
    public function generateForm(Info $info)
    {
        if (! $this->merchant) {
            throw new \LogicException('empty merchant');
        }

        $url = $this->isProduction? static::CHECKOUT_URL_PRODUCTION: static::CHECKOUT_URL_TEST;

        $tradeInfo = $this->merchant->countTradeInfo($info);

        $tradeSha = $this->merchant->countTradeSha($tradeInfo);

        $version = static::VERSION;

        return <<<EOT
<form name="newebpay" id="{$this->formId}" method="post" action="{$url}" style="display:none;">
    <input type="text" name="MerchantID" value="{$this->merchant->getId()}" type="hidden"/>
    <input type="text" name="TradeInfo" value="{$tradeInfo}" type="hidden"/>
    <input type="text" name="TradeSha" value="{$tradeSha}" type="hidden"/>
    <input type="text" name="Version" value="{$version}" type="hidden"/>
</form>
EOT;
    }

    /**
     * @param  OrderInterface  $order
     * @return array
     */
    public function query(OrderInterface $order)
    {
        if (! $this->merchant) {
            throw new \LogicException('empty merchant');
        }

        $url = $this->isProduction? static::QUERY_URL_PRODUCTION: static::QUERY_URL_TEST;

        $payload = [
            'MerchantID' => $this->merchant->getId(),
            'Version' => '1.1',
            'RespondType' => 'JSON',
            'CheckValue' => $this->countCheckValue($order),
            'TimeStamp' => time(),
            'MerchantOrderNo' => $order->getMerchantOrderNo(),
            'Amt' => $order->getAmt(),
        ];

        return $this->post($url, $payload);
    }
    
    public function setIsProduction(bool $isProduction)
    {
        $this->isProduction = $isProduction;

        return $this;
    }

    public function setFormId(string $formId)
    {
        $this->formId = $formId;

        return $this;
    }

    public function setMerchant(Merchant $merchant)
    {
        $this->merchant = $merchant;

        return $this;
    }

    /**
     * @param  OrderInterface  $order
     * @return string
     */
    protected function countCheckValue(OrderInterface $order)
    {
        $payload = [
            'IV' => $this->merchant->getHashIv(),
            'Amt' => $order->getAmt(),
            'MerchantID' => $this->merchant->getId(),
            'MerchantOrderNo' => $order->getMerchantOrderNo(),
            'Key' => $this->merchant->getHashKey(),
        ];

        return strtoupper(hash('sha256', http_build_query($payload)));
    }

    protected function post(string $url, array $payload)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    /**
     * @return Merchant
     */
    public function getMerchant()
    {
        return $this->merchant;
    }
}
