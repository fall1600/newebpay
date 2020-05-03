<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Contracts\AliPayProductInterface;
use fall1600\Package\Newebpay\Info\AliPayInfo;

class AliPayProductInfo extends AliPayInfo
{
    /** @var AliPayInfo */
    protected $info;

    /**
     * 訂單中品項的流水號, 從1開始遞增
     * @var int
     */
    protected $index;

    /** @var AliPayProductInterface */
    protected $product;

    public function __construct(AliPayInfo $info, int $index, AliPayProductInterface $product)
    {
        $this->info = $info;

        $this->index = $index;

        $this->product = $product;
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                "Pid{$this->index}" => $this->product->getProductId(),
                "Title{$this->index}" => $this->product->getTitle(),
                "Desc{$this->index}" => $this->product->getDescription(),
                "Price{$this->index}" => $this->product->getPrice(),
                "Qty{$this->index}" => $this->product->getQuantity(),
            ];
    }
}
