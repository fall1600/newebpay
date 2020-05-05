<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;

class Comment extends InfoDecorator
{
    /** @var Info */
    protected $info;

    /**
     * 商店備註
     *  若提供此參數則會在付款頁面顯示商店資訊
     * @var string
     */
    protected $desc;

    public function __construct(Info $info, string $comment)
    {
        $this->info = $info;

        $this->setComment($comment);
    }

    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'OrderComment' => $this->desc,
            ];
    }

    protected function setComment(string $comment)
    {
        if (mb_strlen($comment) > 300) {
            throw new \LogicException('comment must less or equal than 300');
        }

        $this->comment = $comment;
    }
}
