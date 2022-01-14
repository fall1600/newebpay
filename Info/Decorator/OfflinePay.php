<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;
use LogicException;

class OfflinePay extends InfoDecorator
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
     *  消費者選擇離線付款後 藍新要通知你系統付款資訊
     *
     * @var string
     */
    protected $customerUrl;

    /**
     * @param InfoInterface $info
     * @param string $customerUrl
     * @param int|null $ttl
     */
    public function __construct($info, $customerUrl, $ttl = null)
    {
        $this->info = $info;

        $this->customerUrl = $customerUrl;

        $this->setTtl($ttl);
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'ExpireDate' => $this->countExpireDate(),
                'CustomerURL' => $this->customerUrl,
            ];
    }

    /**
     * @param int|null $ttl
     */
    protected function setTtl($ttl = null)
    {
        if ($ttl <= 0) {
            throw new LogicException('ttl must be large than 1');
        }

        if ($ttl > 180) {
            throw new LogicException('ttl must be less than or equal to 180');
        }

        $this->ttl = $ttl;
    }

    /**
     * @return string
     */
    protected function countExpireDate()
    {
        if (!$this->ttl) {
            return '';
        }

        return date('Ymd', strtotime("+$this->ttl days"));
    }
}
