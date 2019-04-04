<?php


namespace Amasty\Input\Model;


use Amazon\Payment\Api\Data\PendingRefundInterface;
use \Magento\Catalog\Model\Product\Type;

class Store extends \Magento\Framework\Model\AbstractModel
{
    protected $collectionFactory;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
        $this->collectionFactory = $collectionFactory;

    }

    public function findBySKU ($pattern) {

        $productCollection = $this->collectionFactory->create();
        $productCollection
            ->addAttributeToSelect(['sku', 'name', 'type_id', 'qty'])
            ->addFieldToFilter('sku', ['like' => $pattern . '%'])
            ->addFieldToFilter('type_id', ['eq' => Type::TYPE_SIMPLE])
            ->setPageSize(7)
            ->setCurPage(1);
        $array = [];

        foreach ($productCollection as $product ) {
            $array[$product->getSku()] = $product->getName();
        }
        return $array;

    }
}