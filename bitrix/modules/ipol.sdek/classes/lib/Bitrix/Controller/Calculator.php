<?php

namespace Ipolh\SDEK\Bitrix\Controller;


use Ipolh\SDEK\Core\Delivery\Cargo;
use Ipolh\SDEK\Core\Delivery\CargoItem;
use Ipolh\SDEK\Core\Delivery\Location;
use Ipolh\SDEK\Core\Delivery\Shipment;
use Ipolh\SDEK\SDEK\Entity\CalculateListResult;

class Calculator extends abstractController
{
    protected $shipment;
    protected $tarif;

    public function __construct($application = false)
    {
        parent::__construct($application);
    }

    public function makeShipments($sender,$city,$goods,$tarif,$calcMode)
    {
        /*if(!is_numeric($tarif)){
            $arPriority = \CDeliverySDEK::getListOfTarifs($tarif,$calcMode);
        }*/
        $this->application->tarif  = $tarif;
        $this->application->calcMode = $calcMode;

        $this->shipment = new Shipment();

        if(array_key_exists('W',$goods)){
            $goods = array($goods);
        }

        try {
            foreach ($goods as $arGood) {
                $cargo = new Cargo();
                $item  = new CargoItem();
                $item->setGabs($arGood['D_L']*10, $arGood['D_W']*10, $arGood['D_H']*10)->setWeight($arGood['W']*1000);
                $cargo->add($item);
                $this->shipment->addCargo($cargo);
            }
        } catch (\Exception $e){

        }

        $locationFrom = new Location('api');
        $locationFrom->setId($sender);

        $locationTo = new Location('api');
        $locationTo->setId($city);

        $this->shipment->setFrom($locationFrom)->setTo($locationTo);

        $this->shipment->setFields(array('tarif'=>$tarif,'mode'=>$calcMode));
    }

    public function calculate()
    {
        $obResult = $this->application->calculateList($this->shipment,null,null,1,1);
        $this->reworkResult($obResult);
        return $obResult;
    }

    /**
     * @param CalculateListResult $obResult
     */
    protected function reworkResult(&$obResult)
    {
        $arReturn = array();
        if($obResult->isSuccess()) {
            $tarifCodes = $obResult->getResponse()->getTariffCodes();
            if ($tarifCodes) {
                if (is_numeric($this->application->tarif)) {
                    $tariffPriority = array($this->application->tarif);
                } else {
                    $tariffPriority = \CDeliverySDEK::getListOfTarifs($this->application->tarif, $this->application->calcMode);
                }

                $calculatedTariffs = [];
                $tarifCodes->reset();
                while ($obTarif = $tarifCodes->getNext()) {
                    $calculatedTariffs[$obTarif->getTariffCode()] = [
                        "price"           => $obTarif->getDeliverySum(),
                        "termMin"         => $obTarif->getPeriodMin(),
                        "termMax"         => $obTarif->getPeriodMax(),
                        "tarif"           => $obTarif->getTariffCode(),
                        "priceByCurrency" => $obTarif->getDeliverySum()
                        ];
                }

                foreach ($tariffPriority as $tariffCode) {
                    if (array_key_exists($tariffCode, $calculatedTariffs)) {
                        $arReturn = array_merge($calculatedTariffs[$tariffCode], array("success" => 1, "dateMin" => '', "dateMax" => '', "currency" => 'RUB'));
                        break;
                    }
                }
            }
        }

        if(!count($arReturn)){
            if($obResult->getResponse()->getErrors())
            {
                $obResult->getResponse()->getErrors()->reset();
                while ($error = $obResult->getResponse()->getErrors()->getNext()){
                    $arReturn[$error->getCode()] = $error->getMessage();
                }
            } else {
                $arReturn[3] = GetMessage('IPOLSDEK_HINT_FOR_TRANSIT');
            }
        }

        $obResult = $arReturn;
    }
}