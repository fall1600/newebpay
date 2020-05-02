<?php

namespace fall1600\Info\Decorator;

use fall1600\Constants\LangType;
use fall1600\Info\Info;
use fall1600\Info\InfoDecorator;

class LangInfo extends InfoDecorator
{
    /** @var InfoDecorator */
    protected $info;

    /** @var string */
    protected $lang;

    public function __construct(Info $pInfo, string $lang)
    {
        $this->info = $pInfo;

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
