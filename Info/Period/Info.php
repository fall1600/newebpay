<?php

namespace fall1600\Package\Newebpay\Info\Period;

//use fall1600\Package\Newebpay\Constants\Period\PeriodStartType;
use fall1600\Package\Newebpay\Contracts\InfoInterface;
use fall1600\Package\Newebpay\Contracts\Period\ContactInterface;
use fall1600\Package\Newebpay\Contracts\Period\OrderInterface;

abstract class Info implements InfoInterface
{
    /**
     * @var string
     */
    protected $version;

    /**
     * @var OrderInterface
     */
    protected $order;

    /**
     * @var ContactInterface
     */
    protected $contact;

    /**
     * @var string
     */
    protected $periodStartType;

    /**
     * Decorator
     *
     * @return array
     */
    abstract public function getInfo();

    /**
     * @param OrderInterface $order
     * @param ContactInterface $contact
     * @param string $periodStartType
     * @param string $version
     */
    public function __construct(
        $order,
        $contact,
        $periodStartType,
        $version
    )
    {
        $this->order = $order;

        $this->contact = $contact;

        $this->setPeriodStartType($periodStartType);

        $this->setVersion($version);
    }

    /**
     * @param string $periodStartType
     */
    protected function setPeriodStartType($periodStartType)
    {
//        if (! PeriodStartType::isValid($periodStartType)) {
//            throw new \LogicException("unsupported version $periodStartType");
//        }

        $this->periodStartType = $periodStartType;
    }

    /**
     * @param string $version
     */
    protected function setVersion($version)
    {
//        if (! VersionType::isValid($version)) {
//            throw new \LogicException("unsupported version $version");
//        }

        $this->version = $version;
    }
}
