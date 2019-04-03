<?php


namespace Amasty\Input\Model;


use Amazon\Payment\Api\Data\PendingRefundInterface;

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
            ->addFieldToFilter('sku', ['like' => $pattern . '%'])
            ->setPageSize(15)
            ->setCurPage(1);
        $array = [];

        foreach ($productCollection as $product ) {
            $array[$product->getSku()] = $product->getSku();
        }
        return $array;

    }
}