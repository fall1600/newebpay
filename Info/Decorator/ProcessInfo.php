<?php

namespace fall1600\Info\Decorator;

use fall1600\Info\Info;

class ProcessInfo extends Info
{
    /** @var Info */
    protected $info;

    /**
     * 支付通知網址
     *  藍星背景告知系統支付明細的callback url
     *
     * @var string
     */
    protected $notifyUrl;

    /**
     * 支付完成返回的商店網址
     *
     * @var string
     */
    protected $returnUrl;

    /**
     * 支付取消返回的商店網址
     *
     * @var string
     */
    protected $clientBackUrl;

    public function __construct(Info $info, string $notifyUrl, string $returnUrl = null, string $clientBackUrl = null)
    {
        $this->info = $info;

        $this->setNotifyUrl($notifyUrl);

        $this->setReturnUrl($returnUrl);

        $this->setClientBackUrl($clientBackUrl);
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'NotifyURL' => $this->notifyUrl,
                'ReturnURL' => $this->returnUrl,
                'ClientBackURL' => $this->clientBackUrl,
            ];
    }

    protected function setNotifyUrl(string $notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;
    }


    protected function setReturnUrl(string $returnUrl = null)
    {
        $this->returnUrl = $returnUrl;
    }

    protected function setClientBackUrl(string $clientBackUrl = null)
    {
        $this->clientBackUrl = $clientBackUrl;
    }
}
