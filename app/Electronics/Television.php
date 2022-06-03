<?php

namespace App\Electronics;

use App\ElectronicItem;
use App\Interfaces\AllowExtraItemsInterface;

class Television extends ElectronicItem implements AllowExtraItemsInterface
{
    /**
     * The amount of extras allowed
     */
    const QTD_EXTRAS = -1;

    private $extras = array();

    /**
     * This method checks if the eletronic can have more extra items
     * 
     * @return bool
     */
    public function canAddExtras() : bool
    {
        return true;
    }

}