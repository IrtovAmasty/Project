<?php


namespace Amasty\Input\Controller\Action;


use Amasty\Input\Model\Store;
use Magento\Framework\Controller\ResultFactory;

class Autocomplete extends \Magento\Framework\App\Action\Action
{



    protected $model;


    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        Store $model

    )
    {

        $this->model = $model;
        return parent::__construct($context);
    }

    public function execute()
    {
        //echo $this->model->findBySKU($this->getRequest()->getParam('SKU'));

        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($this->model->findBySKU($this->getRequest()->getParam('SKU')));
        return $resultJson;
        //return $this->getRequest()->getParam('data');


        //echo "hello";
        //$this->getRequest()->getParam('SKU');

    }
}