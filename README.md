# Newebpay 藍新金流

程式版本 1.5 <br>
文件版本 1.0.4 <br>
[Official Doc](https://www.newebpay.com/website/Page/content/download_api#1)

## feature

- [x] 多功能收款 MPG
- [x] 單筆交易狀態查詢
- [ ] 信用卡取消授權
- [ ] 信用卡請退款
- [x] 信用卡定期定額

## How to use

### 信用卡定期定額

#### 建立交易資訊 (BasicInfo)
 - $order: 你的訂單物件, 務必實作package 中的OrderInterface
 - $contact: 你的付款人物件, 務必實作package 中的ContactInterface
 - $periodStartType: 檢查卡號模式, 參閱文件p.13
 - $version: 串接程式版本
    - 帶入 1.0 版本,則[背面末三碼]將為必填欄位
    - 帶入 1.1 版本,則[背面末三碼]將為非必填
```php
$info = new \fall1600\Package\Newebpay\Info\Period\BasicInfo($order, $payer, $periodStartType, $version);
```

#### 選填參數

```php

$info = new ReturnUrl($info, 'https://your.return.url');
$info = new NotifyUrl($info, 'https://your.notify.url');
$info = new BackUrl($info, 'https://your.back.url');
$info = new Memo($info, 'your memo here');
```

#### 建立NewebPay 物件, 注入商店資訊, 帶著交易資訊前往藍新申請定期定額
 - $merchantId: 你在藍新商店代號
 - $hashKey: 你在藍新商店專屬的HashKey
 - $hashIv: 你在藍新商店專屬的HashIV

```php
$newebpay = new NewebPay();
$newebpay
    ->setIsProduction(false) // 設定環境, 預設就是走正式機
    ->setMerchant(new Merchant($merchantId, $hashKey, $hashIv))
    ->issue($info);
```

#### 請在你的訂單物件實作 OrderInterface

```php
<?php

namespace Your\Namespace;

use fall1600\Package\Newebpay\Contracts\Period\OrderInterface;

class Order implements OrderInterface
{
    // your order detail...
}
```

#### 請在你的付款人(假設是Member), 實作ContactInterface

```php
<?php

namespace Your\Namespace;

use fall1600\Package\Newebpay\Contracts\Period\ContactInterface;

class Member implements ContactInterface
{
    // your member detail...
}
```

#### 各種url 你分的清楚嗎?
| Name             | 用途                                  | 設定的物件    |    備註                                                   |
|:-----------------|:------------------------------------ |:-------------|:---------------------------------------------------------|
| ReturnURL        | 首次信用卡授權完成後要回到你系統的位置      | ReturnUrl    | 通常用在訂單付款狀態切換, 最重要,所以BasicInfo 就要設定了   |
| NotifyURL        | 每期授權結果通知                        | NotifyUrl    | 每期執行信用卡授權交易完成後, 以Post 方式通知商店授權結果; 若此欄位為空值,程式則將不通知  |
| BackURL          | 取消交易時返回商店的網址                  | BackUrl      | 沒設定就是顯示在藍新                                        |


<hr>

### 多功能收款

#### 建立交易資訊 (BasicInfo)
 - $merchantId: 你在藍新申請的商店代號
 - $notifyUrl: 用來接收藍新付款通知的callback url
 - $order: 你的訂單物件, 務必實作package 中的OrderInterface
 - $payer: 你的付款人物件, 務必實作package 中的PayerInterface 
 
```php
$info = new BasicInfo($merchantId, $notifyUrl, $order, $payer);
```

#### 依場景開啟各種付款方式, 有需要再啟用即可
```php
// 啟用信用卡
$info = new EnableCredit($info);
// 啟用3, 6, 12 期分期付款
$info = new PayInInstallments($info, '3,6,12');
// 啟用超商條碼
$info = new EnableBarcode($info);
// 啟用Google Pay
$info = new EnableGooglePay($info);
// 啟用Web ATM
$info = new EnableWebAtm($info);
// 搭配非即時交易, 設定藍新通知付款資訊的callback url, 以及繳費期限
$info = new OfflinePay($info, $customerUrl, $ttl);
// 在藍新交易完成後導回的網址
$info = new PayComplete($info, $returnUrl);
// 設定讓消費者在付款頁按下返回時可以回導的頁面
$info = new PayCancel($info, $clientBackUrl);

// 文件末有付款方式對應表
```

#### 建立NewebPay 物件, 注入商店資訊, 帶著交易資訊前往藍新付款
 - $merchantId: 你在藍新商店代號
 - $hashKey: 你在藍新商店專屬的HashKey
 - $hashIv: 你在藍新商店專屬的HashIV
 
```php
$newebpay = new NewebPay();
$newebpay
    ->setIsProduction(false) // 設定環境, 預設就是走正式機
    ->setMerchant(new Merchant($merchantId, $hashKey, $hashIv))
    ->checkout($info);
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

#### 解開來自藍新的交易通知
```php
$isValid = $merchant->setRawData($request->all())->validateResponse(); //確認為true 後再往下走

// response 封裝了通知交易的結果, 以下僅列常用methods
$response = $merchant->getResponse();
// 付款成敗
$response->getStatus();
// 取得交易序號
$response->getTradeNo();
// 取得訂單編號, 就是OrderInterface 實作的getMerchantOrderNo
$response->getMerchantOrderNo();
// 付款時間
$response->getPayTime();
```

#### 支付寶 (AliPay)

支付寶付款需提供的參數更多

- $payer: 你的付款人物件, 務必實作package 中的AliPayPayerInterface
- $numberOfProducts: 此訂單的品項數量(integer)
- $product1: 第一個品項(實作AliPayProductInterface)
- $product2: 第二個品項(實作AliPayProductInterface)

```php
$info = new AliPayBasicInfo($merchantId, $notifyUrl, $order, $payer, $numberOfProducts);
$info = new EnableAliPay($info);

$info = new AliPayProduct($info, 1, $product1);
$info = new AliPayProduct($info, 2, $product2);
```

#### 單筆交易查詢
```php
$resp = $newebpay
    ->setMerchant($merchant)
    ->query($order);
```


#### 各種url 你分的清楚嗎?
| Name             | 用途                                  | 設定的物件    |    備註                                                   |
|:-----------------|:------------------------------------ |:-------------|:---------------------------------------------------------|
| NotifyURL        | 通知你系統交易資訊的callback url         | BasicInfo    | 通常用在訂單付款狀態切換, 最重要,所以BasicInfo 就要設定了   |
| CustomerURL      | 離線付款取號完成通知你系統的callback url  | OfflinePay   | 用在紀錄離線付款的取號, 務必設定                            |
| ReturnURL        | 付款完成後要回到你系統的位置              | PayComplete  | 沒設定就是顯示在藍新                                        |
| ClientBackURL    | 交易取消時回到你系統的位置                | PayCancel    | 沒設定就是顯示在藍新                                        |


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

