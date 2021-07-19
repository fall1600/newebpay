<?php

namespace fall1600\Package\Newebpay\Info\Close;

use fall1600\Package\Newebpay\Constants\CreditClose\CloseType;
use fall1600\Package\Newebpay\Constants\CreditClose\IndexType;
use fall1600\Package\Newebpay\Contracts\InfoInterface;
use fall1600\Package\Newebpay\Contracts\Period\OrderInterface;

abstract class Info implements InfoInterface
{
    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * 藍新金流交易序號
     * @var string
     */
    protected $tradeNo;

    /**
     * @var int
     */
    protected $indexType;

    /**
     * 請款或退款
     * @var int
     */
    protected $closeType;

    /**
     * 請退款金額
     * @var int|null
     */
    protected $amt;

    /**
     * @param OrderInterface $order
     * @param string $tradeNo
     * @param int $indexType
     * @param int $closeType
     * @param int|null $amt
     */
    public function __construct(
        OrderInterface $order,
        string $tradeNo,
        int $indexType = IndexType::MERCHANT,
        int $closeType = CloseType::_1,
        int $amt = null
    ) {
        $this->order = $order;

        $this->tradeNo = $tradeNo;

        $this->indexType = $indexType;

        $this->closeType = $closeType;

        $this->setAmt($amt);
    }

    protected function setAmt(int $amt = null)
    {
        if ($amt > $this->order->getAmount()) {
            throw new \LogicException('請退款金額一定不能大於授權金額');
        }

        $this->amt = $this->order->getAmount();
    }
}
