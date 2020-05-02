<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Constants\LangType;
use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;

class LangInfo extends InfoDecorator
{
    /** @var InfoDecorator */
    protected $info;

    /** @var string */
    protected $lang;

    public function __construct(Info $info, string $lang)
    {
        $this->info = $info;

        $this->lang = $lang;
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'LangType' => $this->lang ?? LangType::ZH_TW,
            ];
    }
}
