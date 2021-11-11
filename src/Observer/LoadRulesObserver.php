<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Eriocnemis\RegionShippingRule\Api\GetWebsiteIdsByRuleIdsInterface;
use Eriocnemis\RegionShippingRule\Api\GetCustomerGroupIdsByRuleIdsInterface;
use Eriocnemis\RegionShippingRule\Api\GetMethodsByRuleIdsInterface;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;

/**
 * Load rule additional data observer
 */
class LoadRulesObserver implements ObserverInterface
{
    /**
     * @var GetWebsiteIdsByRuleIdsInterface
     */
    private $getWebsiteIdsByRuleIds;

    /**
     * @var GetCustomerGroupIdsByRuleIdsInterface
     */
    private $getCustomerGroupIdsByRuleIds;

    /**
     * @var GetMethodsByRuleIdsInterface
     */
    private $getMethodsByRuleIds;

    /**
     * Initialize observer
     *
     * @param GetWebsiteIdsByRuleIdsInterface $getWebsiteIdsByRuleIds
     * @param GetCustomerGroupIdsByRuleIdsInterface $getCustomerGroupIdsByRuleIds
     * @param GetMethodsByRuleIdsInterface $getMethodsByRuleIds
     */
    public function __construct(
        GetWebsiteIdsByRuleIdsInterface $getWebsiteIdsByRuleIds,
        GetCustomerGroupIdsByRuleIdsInterface $getCustomerGroupIdsByRuleIds,
        GetMethodsByRuleIdsInterface $getMethodsByRuleIds
    ) {
        $this->getWebsiteIdsByRuleIds = $getWebsiteIdsByRuleIds;
        $this->getCustomerGroupIdsByRuleIds = $getCustomerGroupIdsByRuleIds;
        $this->getMethodsByRuleIds = $getMethodsByRuleIds;
    }

    /**
     * Load website ids
     *
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     */
    public function execute(Observer $observer): void
    {
        $collection = $observer->getEvent()->getData('collection');
        $ruleIds = $collection->getColumnValues(RuleInterface::RULE_ID);
        if (0 < count($ruleIds)) {
            /* preload related data */
            $websiteIds = $this->getWebsiteIdsByRuleIds->execute($ruleIds);
            $customerGroupIds = $this->getCustomerGroupIdsByRuleIds->execute($ruleIds);
            $methods = $this->getMethodsByRuleIds->execute($ruleIds);
            /* add related data to rules */
            foreach ($collection as $rule) {
                $rule->setData(RuleInterface::WEBSITE_IDS, $websiteIds[$rule->getId()] ?? []);
                $rule->setData(RuleInterface::CUSTOMER_GROUP_IDS, $customerGroupIds[$rule->getId()] ?? []);
                $rule->setData(RuleInterface::SHIPPING_METHODS, $methods[$rule->getId()] ?? []);
            }
        }
    }
}
