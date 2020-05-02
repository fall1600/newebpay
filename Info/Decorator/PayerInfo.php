<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;

class PayerInfo extends Info
{
    /** @var Info */
    protected $info;

    /** @var string */
    protected $email;

    /** @var bool */
    protected $canModifyEmail;

    /** @var bool */
    protected $loginType;

    public function __construct(Info $info, string $email, bool $canModifyEmail = true, bool $loginType = false)
    {
        $this->info = $info;

        $this->setEmail($email);

        $this->setCanModifyEmail($canModifyEmail);

        $this->setLoginType($loginType);
    }

    /**
     * Email: 付款人信箱, 當交易完成或付款完成, 用來通知付款人
     * EmailModify: 1=可修改, 0=不可修改
     * LoginType: 1=必須登入藍星會員, 0=不須登入藍星會員
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'Email' => $this->email,
                'EmailModify' => $this->canModifyEmail? 1: 0,
                'LoginType' => $this->loginType? 1: 0,
            ];
    }

    protected function setEmail(string $email)
    {
        $this->email = $email;
    }

    protected function setCanModifyEmail(bool $canModifyEmail)
    {
        $this->canModifyEmail = $canModifyEmail;
    }

    protected function setLoginType(bool $loginType)
    {
        $this->loginType = $loginType;
    }
}
