<?php

namespace fall1600\Package\Newebpay\Info\Period;

//use fall1600\Package\Newebpay\Constants\Period\PeriodStartType;
use fall1600\Package\Newebpay\Constants\Period\VersionType;
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
     * @param   OrderInterface    $order
     * @param   ContactInterface  $contact
     * @param   string            $periodStartType
     * @param   string            $version
     */
    public function __construct(
        OrderInterface $order,
        ContactInterface $contact,
        string $periodStartType,
        string $version = VersionType::V1_0
    ) {
        $this->order = $order;

        $this->contact = $contact;

        $this->setPeriodStartType($periodStartType);

        $this->setVersion($version);
    }

    protected function setPeriodStartType(string $periodStartType)
    {
//        if (! PeriodStartType::isValid($periodStartType)) {
//            throw new \LogicException("unsupported version $periodStartType");
//        }

        $this->periodStartType = $periodStartType;
    }

    protected function setVersion(string $version)
    {
//        if (! VersionType::isValid($version)) {
//            throw new \LogicException("unsupported version $version");
//        }

        $this->version = $version;
    }
}
