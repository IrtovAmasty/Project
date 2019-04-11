<?php

namespace Amasty\Input\Controller\Cart;

class AddToCart extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Checkout\Model\Cart
     */
    protected $cart;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Request\Http $request
    ) {
        $this->productRepository = $productRepository;
        $this->cart = $cart;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->request = $request;

        return parent::__construct($context);
    }

    public function execute()
    {
        $sku = $this->getRequest()->getParam('SKU');
        $qty = $this->getRequest()->getParam('QTY');

        $product = $this->productRepository->get($sku);

        $stockQty = $product->getExtensionAttributes()->getStockItem()->getQty();

        if ($qty > $stockQty) {

            $productId = $product->getId();
            $salt = 'salty_salt';
            $saltedHash = md5($productId . $salt);
            $url = 'http://m231ceo.student5.ap72copy.sty/customrouter/stock/addtostock?SKU=' . $sku . '&hash=' . $saltedHash;

            $store = $this->storeManager->getStore()->getId();
            $transport = $this->transportBuilder->setTemplateIdentifier('email_template')
                ->setTemplateOptions(['area' => 'frontend', 'store' => $store])
                ->setTemplateVars(
                    [
                        'store' => $this->storeManager->getStore(),
                    ]
                )
                ->setFrom(["name" => "oleg", "email" => "mrirotv@gmail.com"])
                ->addTo('mrirtov@gmail.com')
                ->getTransport();
            $transport->sendMessage();

            $this->messageManager->addError('Sorry... We don\'t have enough items in the stock');

        } else {
            $param = [
                'qty' => $qty
            ];

            $this->cart->addProduct($product, $param);
            $this->cart->save();

            $this->messageManager->addSuccess('Congratulation! You have added item into the cart!');
        }
    }
}
