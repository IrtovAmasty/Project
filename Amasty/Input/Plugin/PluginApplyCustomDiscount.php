<?php


namespace Amasty\Input\Plugin;


use Magento\Store\Model\ScopeInterface;

class PluginApplyCustomDiscount
{
    /**
     * @var \Magento\SalesRule\Model\RuleFactory
     */
    protected $ruleFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory
     */
    protected $collectionFactory;

    public function __construct(
        \Magento\SalesRule\Model\RuleFactory $ruleFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory $collectionFactory
    )
    {
        $this->ruleFactory = $ruleFactory;
        $this->scopeConfig = $scopeConfig;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param \Magento\SalesRule\Model\RulesApplier $rulesApplier
     * @param $item
     * @param $rules
     * @param $skipValidation
     * @param $couponCode
     * @return array
     * @throws \Exception
     */
    public function beforeApplyRules(\Magento\SalesRule\Model\RulesApplier $rulesApplier, $item, $rules, $skipValidation, $couponCode)
    {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');
        $subTotal = (int)$cart->getQuote()->getSubtotal();

        $arrayOfCustomDiscounts = json_decode($this->scopeConfig->getValue('discounts/setting_discounts/navigation_links', ScopeInterface::SCOPE_STORE), true);

        $discount = 0;
        $varMaxPrice = 0;

        foreach ($arrayOfCustomDiscounts as $inner) {

            if ($subTotal >= (int)$inner['price'] && (int)$inner['price'] > $varMaxPrice) {
                $varMaxPrice = $inner['price'];
                $discount = $inner['discount_amount'];
            }
        }

        $ruleData = [
            "name" => "Custom Cart Rule for price >= " . $varMaxPrice,
            "description" => "Custom Cart Rule",
            "from_date" => null,
            "to_date" => null,
            "uses_per_customer" => "0",
            "is_active" => "1",
            "stop_rules_processing" => "0",
            "is_advanced" => "1",
            "product_ids" => null,
            "sort_order" => "0",
            "simple_action" => "by_percent",
            "discount_amount" => $discount,
            "discount_qty" => null,
            "discount_step" => "0",
            "apply_to_shipping" => "0",
            "times_used" => "0",
            "is_rss" => "1",
            "coupon_type" => "1",
            "use_auto_generation" => "0",
            "uses_per_coupon" => "0",
            "simple_free_shipping" => "0",
            "customer_group_ids" => [0],
            "website_ids" => [1],
            "coupon_code" => null,
            "store_labels" => [],
            "conditions_serialized" => '',
            "actions_serialized" => '',
        ];

        $rulesCollection = $this->collectionFactory->create();
        $rulesForAnswer = $rulesCollection->addFieldToFilter('name', $ruleData['name']);

        if ($rulesForAnswer->count() == 0) {
            $ruleModel = $this->ruleFactory->create();
            $ruleModel->setData($ruleData);
            $ruleModel->save();
            $rulesForAnswer = $rulesCollection->addFieldToFilter('name', $ruleData['name']);
        }
        return array($item, $rulesForAnswer, $skipValidation, $couponCode);
    }
}
