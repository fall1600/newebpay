<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Constants\Language;
use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;

class LanguageInfo extends InfoDecorator
{
    /** @var Info */
    protected $info;

    /** @var string */
    protected $language;

    public function __construct(Info $info, string $language)
    {
        $this->info = $info;

        $this->language = $language;
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'LangType' => $this->language ?? Language::ZH_TW,
            ];
    }
}
