<?php

namespace Amasty\Input\Plugin;

class PluginSortCart
{
    /**
     * @param \Amasty\Input\Block\ShoppingCart $cart
     * @param $result
     * @return array
     */
    public function afterGetQuoteData(\Amasty\Input\Block\ShoppingCart $cart, $result)
    {

        $items = $result->getItems();


        foreach ($items as $item) {
            $array[] = (int)$item->getId();
        }
        rsort($array);

        $i = 0;
        foreach ($items as $item) {
            $respArray[] = $result->getItemById($array[$i]);
            $i++;
        }

        return $respArray;
    }
}