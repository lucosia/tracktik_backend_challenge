<?php

namespace App\Electronics;

use App\ElectronicItem;
use App\Interfaces\AllowExtraItemsInterface;

class Microwave extends ElectronicItem implements AllowExtraItemsInterface
{
    /**
     * The amount of extras allowed
     */
    const QTD_EXTRAS = 0;

    /**
     * This method checks if the eletronic can have more extra items
     * 
     * @return bool
     */
    public function canAddExtras(): bool
    {
        if (self::QTD_EXTRAS == 0) {
            return false;
        }

        return true;
    }
}