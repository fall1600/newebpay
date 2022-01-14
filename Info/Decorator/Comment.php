<?php

namespace fall1600\Package\Newebpay\Info\Decorator;

use fall1600\Package\Newebpay\Info\Info;
use fall1600\Package\Newebpay\Info\InfoDecorator;
use LogicException;

class Comment extends InfoDecorator
{
    /** @var Info */
    protected $info;

    /**
     * 商店備註
     *  若提供此參數則會在付款頁面顯示商店資訊
     * @var string
     */
    protected $comment;

    /**
     * @param InfoInterface $info
     * @param string $comment
     */
    public function __construct($info, $comment)
    {
        parent::__construct();
        $this->info = $info;

        $this->setComment($comment);
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info->getInfo() +
            [
                'OrderComment' => $this->comment,
            ];
    }

    /**
     * @param string $comment
     */
    protected function setComment($comment)
    {
        if (mb_strlen($comment) > 300) {
            throw new LogicException('comment must less or equal than 300');
        }

        $this->comment = $comment;
    }
}
