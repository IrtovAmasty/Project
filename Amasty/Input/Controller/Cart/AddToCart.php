<?php


namespace Amasty\Input\Controller\Cart;


class AddToCart extends \Magento\Framework\App\Action\Action
{

    protected $cart;
    protected $productRepository;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Checkout\Model\Cart $cart

    )
    {
        $this->productRepository = $productRepository;
        $this->cart = $cart;

        return parent::__construct($context);
    }

    public function execute()
    {
        $sku = $this->getRequest()->getParam('SKU');
//        $qty = $this->getRequest()->getParam('QTY');

        $product = $this->productRepository->get($sku);

        $param = [
            'qty' => '1'
        ];

        $this->cart->addProduct($product, $param);
        $this->cart->save();

        //return $this->_redirect('customrouter/index/index');


    }
}