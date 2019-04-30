<?php

namespace Amasty\Input\Block;

class ShoppingCart extends \Magento\Framework\View\Element\Template
{
    /**
     * @var
     */
    protected $_cart;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        array $data = []
    ) {
        $this->_checkoutSession = $checkoutSession;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Quote\Model\Quote
     */
    public function getQuoteData()
    {
        $quote = $this->_checkoutSession->getQuote();
        return $quote;
    }
}
