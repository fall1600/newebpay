# Newebpay 藍星金流


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
$info = new GooglePayInfo($info);
$info = new SamsungPayInfo($info);
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
| PayInFullInfo     | 信用卡(一次結清)           | 即時交易           |
| WebAtmInfo        | WebATM                  | 即時交易            |
| VaccInfo          | ATM 轉帳                 | 非即時交易          |
| CvsInfo           | 超商代碼繳費              | 非即時交易          |
| BarcodeInfo       | 超商條碼繳費              | 非即時交易          |
| LogisticsInfo     | 超商取貨付款              | 非即時交易          |
| AliPayEnableInfo  | 支付寶                   | 非即時交易          |
| EzPayInfo         | ezPay 電子錢包            | 即時交易, 非即時交易 |
| LinePayInfo       | LINE Pay                | 即時交易           |

