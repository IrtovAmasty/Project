<?php

namespace Amasty\Input\Model\Config\Frontend\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class DiscountAmount extends AbstractFieldArray
{
    protected function _prepareToRender()
    {
        $this->addColumn(
            'price',
            [
                'label' => __('Price')
            ]
        );
        $this->addColumn(
            'discount_amount',
            [
                'label' => __('Discount')
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('New discount');
    }
}
