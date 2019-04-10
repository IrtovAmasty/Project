<?php


namespace Amasty\Input\Plugin;


class PluginAddToCard
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    public function __construct(\Magento\Catalog\Api\ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param \Magento\Checkout\Controller\Cart\Add $productForAdding
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeExecute(\Magento\Checkout\Controller\Cart\Add $productForAdding) {


        if ($productForAdding->getRequest()->getParam('product') === null) {
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
}
