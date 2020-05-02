<?php

namespace fall1600\Info\Decorator;

use fall1600\Info\Info;

class ProcessInfo extends Info
{
    /** @var Info */
    protected $info;

    /**
     * 支付完成返回的商店網址
     *
     * @var string
     */
    protected $returnUrl;

    /**
     * 支付通知網址
     *  藍星背景告知系統支付明細的callback
     *
     * @var string
     */
    protected $notifyUrl;

    /**
     * 支付取消返回的商店網址
     *
     * @var string
     */
    protected $clientBackUrl;

    public function __construct(Info $info, string $returnUrl, string $notifyUrl, string $clientBackUrl)
    {
        $this->info = $info;

        $this->setReturnUrl($returnUrl);

        $this->setNotifyUrl($notifyUrl);

        $this->setClientBackUrl($clientBackUrl);
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'ReturnURL' => $this->returnUrl,
                'NotifyURL' => $this->notifyUrl,
            ];
    }

    protected function setReturnUrl(string $returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }

    protected function setNotifyUrl(string $notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;
    }

    protected function setClientBackUrl(string $clientBackUrl)
    {
        $this->clientBackUrl = $clientBackUrl;
    }
}
