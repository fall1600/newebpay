<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;

class OfflinePayInfo extends InfoDecorator
{
    /** @var Info */
    protected $info;

    /**
     * 離線付款有效天數, 預設7天, 最長可支援180天
     *  用來計算參數 ExpireDate
     *
     * @var int
     */
    protected $ttl;

    /**
     * 商店取號網址
     *  消費者選擇離線付款後 藍星要redirect 的網址
     *
     * @var string
     */
    protected $customerUrl;

    public function __construct(Info $info, int $ttl, string $customerUrl = null)
    {
        $this->info = $info;

        $this->setTtl($ttl);

        $this->setCustomerUrl($customerUrl);
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'ExpireDate' => $this->countExpireDate(),
                'CustomerURL' => $this->customerUrl,
            ];
    }

    protected function setTtl(int $ttl)
    {
        if ($ttl <= 0) {
            throw new \LogicException('ttl must be large than 1');
        }

        if ($ttl > 180) {
            throw new \LogicException('ttl must be less than or equal to 180');
        }

        $this->ttl = $ttl;
    }


    protected function setCustomerUrl(string $customerUrl = null)
    {
        $this->customerUrl = $customerUrl;
    }

    /**
     * @return string
     */
    protected function countExpireDate()
    {
        if (! $this->ttl) {
            return '';
        }

        return date(
            'Ymd',
            mktime(
                0,
                0,
                0,
                date('m'),
                date('d') + $this->ttl,
                date('Y')
            )
        );
    }
}
