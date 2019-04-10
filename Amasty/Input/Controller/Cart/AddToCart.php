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

    protected $transportBuilder;

    protected $storeManager;

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

        $stockQTY = $product->getExtensionAttributes()->getStockItem()->getQty();

        if ((float)$qty > $stockQTY) {

//            $store = $this->storeManager->getStore()->getId();
//            $transport = $this->transportBuilder->setTemplateIdentifier('email_template')
//                ->setTemplateOptions(['area' => 'frontend', 'store' => $store])
//                ->setTemplateVars(
//                    [
//                        'store' => $this->storeManager->getStore(),
//                    ]
//                )
//                ->setTemplateVars(array())
//                ->setFrom(array("name" => "arushi", "email" => "arushi.bansal@jispl.com"))
//                ->addTo('mrirtov@gmail.com')
//                ->getTransport();
//            $transport->sendMessage();

//            $email = new \Zend_Mail();
//
//            $email->setBodyText('Hello');
//            $email->setFrom('owner@example.com', 'Owner');
//            $email->addTo('mrirtov@gmail.com', 'oleg');
//            $email->setSubject('Test');
//
//            try {
//                $email->send();
//            }
//            catch (Exception $ex) {
//                Mage::getSingleton('core/session')
//                    ->addError(Mage::helper('yourmodule')
//                        ->__('Unable to send email.'));
//            }

            $receiverMail = "mrirtov@gmail.com";
            $templateId = 1;        // id of email template
            $storeId = 1;           // desired store id
            $templateParams = [];   // params of template by array

//php mail
            var_dump(mail($receiverMail, "Test Subject", "Test Message"));

            $this->messageManager->addError('Sorry... We don\'t have enough items in the stock');

        }
        else {
            $param = [
                'qty' => $qty
            ];

            $this->cart->addProduct($product, $param);
            $this->cart->save();

            $this->messageManager->addSuccess('Congratulation! You have added item into the cart!');
        }
    }
}
