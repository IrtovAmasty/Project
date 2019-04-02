<?php

namespace Amasty\Input\Controller;
class CustomRouter implements \Magento\Framework\App\RouterInterface
{
    protected $actionFactory;
    protected $_response;
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->scopeConfig = $scopeConfig;
    }
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        $var = $this->scopeConfig->getValue('routes/general/display_text', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if($identifier == $var) {

            $request->setModuleName('customrouter')-> //module name
            setControllerName('index')-> //controller name
            setActionName('index'); //custom parameters
        } else {
            return false;
        }
        return $this->actionFactory->create(
            \Magento\Framework\App\Action\Forward::class,
            ['request' => $request]
        );
    }
}
