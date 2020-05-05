# Newebpay 藍星金流

程式版本 1.5 <br>
文件版本 1.0.4 <br>
[Official Doc](https://www.newebpay.com/website/Page/content/download_api#1)

## How to use

#### 建立交易資訊 (BasicInfo)
 - $order: 你的訂單物件, 務必實作package 中的OrderInterface
 - $payer: 你的付款人物件, 務必實作package 中的PayerInterface
 - $merchantId: 你在藍星申請的商店代號
 - $returnUrl: 用來接收藍星付款通知的webhook 
 
```php
$info = new BasicInfo($order, $payer, $merchantId, $returnUrl);
```

#### 依場景開啟各種付款方式
```php
// 開啟信用卡
$info = new EnableCredit($info);
// 開啟3, 6, 12 期分期付款
$info = new PayInInstallments($info, '3,6,12');
// 開啟超商條碼
$info = new EnableBarcode($info);
// 離線付款回導頁設定, 需設定繳費截止在幾天內(ttl), 以及取號完成後導回的網址
$info = new OfflinePay($info, $ttl, $customerUrl);

// 文件末有付款方式對應表
```

#### 建立NewebPay 物件, 注入交易資訊, 注入加密物件後, 導去藍星付款
 - $hashKey: 你在藍星商店專屬的HashKey
 - $hashIv: 你在藍星商店專屬的HashIV
 
```php
$newebpay = new NewebPay();
$newebpay->setInfo($info)
    ->setTradeInfoEncrypt(new TradeInfoEncrypt($hashKey, $hashIv))
    ->echoCheckoutPage();
```

#### 請在你的訂單物件實作 OrderInterface

```php
<?php

namespace Your\Namespace;

use fall1600\Package\Newebpay\Contracts\OrderInterface;

class Order implements OrderInterface
{
    // your order detail...
}

```

#### 請在你的付款人(假設是Member), 實作PayerInterface

```php
<?php

namespace Your\Namespace;

use fall1600\Package\Newebpay\Contracts\PayerInterface;

class Member implements PayerInterface
{
    // your member detail...
}
```




#### 付款方式對應的物件

| Class             | 付款方式                  | 交易性質           |
|:------------------|:------------------------|:------------------|
| EnableCredit      | 信用卡(一次結清)           | 即時交易           |
| EnableWebAtm      | WebATM                  | 即時交易            |
| EnableVacc        | ATM 轉帳                 | 非即時交易          |
| EnableCvs         | 超商代碼繳費              | 非即時交易          |
| EnableBarcode     | 超商條碼繳費              | 非即時交易          |
| EnableCvsCom      | 超商取貨付款              | 非即時交易          |
| EnableAliPay      | 支付寶                   | 非即時交易          |
| EnableEzPay       | ezPay 電子錢包            | 即時交易, 非即時交易 |
| EnableLinePay     | LINE Pay                | 即時交易           |

