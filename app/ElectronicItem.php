<?php

namespace App;

class ElectronicItem
{
    
    /**
     * @var float
     */
    private $price;
    
    /**
     * @var string
     */
    private $type;
    private $wired;
    private $extras;
    
    const ELECTRONIC_ITEM_TELEVISION = 'television';
    const ELECTRONIC_ITEM_CONSOLE = 'console';
    const ELECTRONIC_ITEM_MICROWAVE = 'microwave';
    
    public static $types = array(
        self::ELECTRONIC_ITEM_CONSOLE,
        self::ELECTRONIC_ITEM_MICROWAVE, 
        self::ELECTRONIC_ITEM_TELEVISION
    );
    
    function getPrice()
    {
        return $this->price;
    }
    
    function getType()
    {
        return $this->type;
    }
    
    function getWired()
    {
        return $this->wired;
    }
    
    function setPrice($price)
    {
        $this->price = $price;
    }
    
    function setType($type)
    {
        $this->type = $type;
    }
    
    function setWired($wired)
    {
        $this->wired = $wired;
    }

    public function setExtras(ElectronicItem $item) : void
    {
        $this->extras[] = $item;
    }

    public function getExtras() : array
    {
        return $this->extras;
    }
    
    public function countExtras() : int
    {
        return $this->extras !== null ? count($this->extras) : 0;
    }

    public function getSortedExtras()
    {
        if($this->countExtras() <= 0){
            return array();
        }

        $extraSorted = array();
        $extras = $this->getExtras();

        foreach ($extras as $extraKey => $extraValue) {
            $extraSorted[($extraValue->getPrice() * 100)] = $extraValue;
        }
        
        ksort($extraSorted, SORT_NUMERIC);
        
        return $extraSorted;
    }
    
    public function getTotalPriceOfItemAndExtras()
    {
        $total = 0.00;
        $total += $this->getPrice();

        if($this->countExtras() <= 0){
            return number_format($total, 2, '.', '');
        }

        $extras = $this->getExtras();
        
        foreach ($extras as $extraKey => $extraValue) {
            $total += $extraValue->getPrice();
        }

        return number_format($total, 2, '.', '');
    }
}