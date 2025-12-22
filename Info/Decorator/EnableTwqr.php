<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;

class EnableTwqr extends Enable
{
    /**
     *  TWQR_LifeTime: 以此秒數產生 TWQR 到期時間，未帶則預設 300 秒 (1 天 86400 秒)，最高上限 31天 (2678400 秒)
     */
    protected $lifetime;

    public function __construct(Info $info, int $lifetime)
    {
        $this->info = $info;

        $this->setLifetime($lifetime);
    }

    /**
     * TWQR 啟用 (TWQR/簡單付電子錢包)
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'TWQR' => $this->isEnable? 1: 0,
                'TWQR_LifeTime' => $this->lifetime,
            ];
    }

    protected function setLifetime(?int $lifetime = null)
    {
        if (null === $lifetime) {
            $lifetime = 300;
        }

        if ($lifetime <= 0) {
            throw new \LogicException('lifetime must be large than 1');
        }

        if ($lifetime > 2678400) {
            throw new \LogicException('lifetime must be less than or equal to 2678400');
        }

        $this->lifetime = $lifetime;
    }
}
