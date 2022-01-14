<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Constants\LanguageType;
use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;

class Language extends InfoDecorator
{
    /** @var Info */
    protected $info;

    /** @var string */
    protected $language;

    /**
     * @param InfoInterface $info
     * @param string $language
     */
    public function __construct($info, $language)
    {
        parent::__construct();
        $this->info = $info;

        $this->language = $language;
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'LangType' => isset($this->language) ? $this->language : LanguageType::ZH_TW,
            ];
    }
}
