<?php


namespace Amasty\Input\Plugin;


class PluginAddToCard
{

    protected $productRepository;

    /**
     * PluginAddToCard constructor.
     * @param $productRepository
     */
    public function __construct(\Magento\Catalog\Api\ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function beforeExecute(\Magento\Checkout\Controller\Cart\Add $productForAdding) {
        $sku = $productForAdding->getRequest()->getParam('SKU');
        $productBySKU = $this->productRepository->get($sku);

        $product = $productBySKU->getId();
        $qty = $productForAdding->getRequest()->getParam('QTY');

        $param = [
            'product' => $product,
            'qty' => $qty
        ];
        $productForAdding->getRequest()->setParams($param);




    }
}