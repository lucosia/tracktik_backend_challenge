<?php

namespace App\Electronics;

use App\ElectronicItem;
use App\Interfaces\AllowExtraItemsInterface;

class Console extends ElectronicItem implements AllowExtraItemsInterface
{
    /**
     * The amount of extras allowed
     */
    const QTD_EXTRAS = 4;

    private $extras = array();

    /**
     * This method checks if the eletronic can have more extra items
     * 
     * @return bool
     */
    public function canAddExtras() : bool
    {
        return $this->countExtras() < self::QTD_EXTRAS;
    }
}