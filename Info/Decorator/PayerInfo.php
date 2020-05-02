<?php

namespace fall1600\Info\Decorator;

use fall1600\Info\Info;

class PayerInfo extends Info
{
    /** @var Info */
    protected $info;

    /** @var string */
    protected $email;

    public function __construct(Info $info, string $email)
    {
        $this->info = $info;

        $this->setEmail($email);
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'email' => $this->email,
            ];
    }

    protected function setEmail(string $email)
    {
        $this->email = $email;
    }
}
