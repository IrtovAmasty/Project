<?php


namespace Amasty\Input\Controller\Stock;


class AddToStock extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\CatalogInventory\Api\StockRegistryInterface
     */
    protected $stockRegistry;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
    ) {
        $this->stockRegistry = $stockRegistry;

        return parent::__construct($context);
    }

    public function execute()
    {
        $sku = $this->getRequest()->getParam('SKU');
        $hash = $this->getRequest()->getParam('hash');

        $stockItem = $this->stockRegistry->getStockItemBySku($sku);

        $productId = $stockItem->getProductId();

        $salt = 'salty_salt';
        $saltedHash = md5($productId . $salt);

        if (strcmp($hash, $saltedHash) == 0) {
            $qty = $stockItem->getQty() + 50;

            $stockItem->setQty($qty);
            $this->stockRegistry->updateStockItemBySku($sku, $stockItem);

            echo 'Добавлено 50 единиц продукта ' . $sku . ' в хранилище';

        } else {
            echo 'Не удалось пополнить продукт в хранилище';
        }
    }
}
