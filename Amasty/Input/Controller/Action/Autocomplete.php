<?php

namespace Amasty\Input\Controller\Action;

use Amasty\Input\Model\Store;
use Magento\Framework\Controller\ResultFactory;

class Autocomplete extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Store
     */
    protected $model;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        Store $model
    ) {
        $this->model = $model;
        return parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($this->model->findBySKU($this->getRequest()->getParam('SKU')));
        return $resultJson;
    }
}
