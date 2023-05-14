<?php

namespace Ipolh\SDEK\Bitrix\Controller;


use Ipolh\SDEK\Legacy\transitApplication;
use Ipolh\SDEK\SDEK\SdekApplication;

class Order extends abstractController
{

    protected $order;
    protected $result;

    /**
     * orderController constructor.
     * @param SdekApplication|transitApplication|null $application
     * @param \Ipolh\SDEK\Core\Order\Order $order
     */
    public function __construct($application,$order = false)
    {
        parent::__construct($application);

        if ($order) {
            $this->order = $order;
        }
    }

    /**
     * @return \Ipolh\SDEK\SDEK\Entity\OrderMakeResult|string
     */
    public function sendOrder()
    {
        return $this->application->orderMake($this->order,1,'4b1d17d262bdf16e36b9070934c74d47');
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return \Ipolh\SDEK\Core\Order\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param \Ipolh\SDEK\Core\Order\Order $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }
}