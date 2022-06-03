<?php

namespace App\Services;

use App\ElectronicItem;

class ElectronicItems
{

    /**
     * Store the items list
     * 
     * @var array
     */
    private $items = array();

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Returns an array of items sorted by value ASC
     *
     * @return array
     */
    public function sortItems()
    {
        $sorted = array();
        
        foreach ($this->items as $item) {
            $sorted[($item->getPrice() * 100)] = $item;
        }
        
        ksort($sorted, SORT_NUMERIC);
        
        return $sorted;
    }
    
    /**
     * 
     * @param string $type
     * @return array|bool
     */
    public function getItemsByType($type)
    {

        if (in_array($type, ElectronicItem::$types)) {
            
            $callback = function($item) use ($type) {
                return $item->getType() == $type;
            };

            return array_filter($this->items, $callback);
        }

        return false;
    }

    /**
     * Get total price of shopping list
     * 
     * @return float
     */
    public function getTotalPrice() : float
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getPrice();

            if ($item->countExtras() != 0 && !empty($item->getExtras())) {
                $total += $this->getTotalPriceOfExtras($item->getExtras());
            }
        }

        return number_format($total, 2, '.', '');
    }

    /**
     * Get the total price of extras
     * 
     * @return float
     */
    private function getTotalPriceOfExtras(array $extras) : float
    {
        $total = 0.00;

        foreach ($extras as $item) {
            $total += $item->getPrice();
        }

        return number_format($total, 2, '.', '');
    }
}