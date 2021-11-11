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
use Eriocnemis\RegionShippingRule\Api\GetCustomerGroupIdsByRuleIdInterface;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;

/**
 * Load customer group ids observer
 */
class LoadCustomerGroupObserver implements ObserverInterface
{
    /**
     * @var GetCustomerGroupIdsByRuleIdInterface
     */
    private $getCustomerGroupIdsByRuleId;

    /**
     * Initialize observer
     *
     * @param GetCustomerGroupIdsByRuleIdInterface $getCustomerGroupIdsByRuleId
     */
    public function __construct(
        GetCustomerGroupIdsByRuleIdInterface $getCustomerGroupIdsByRuleId
    ) {
        $this->getCustomerGroupIdsByRuleId = $getCustomerGroupIdsByRuleId;
    }

    /**
     * Load customer group ids
     *
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     */
    public function execute(Observer $observer): void
    {
        $rule = $observer->getEvent()->getData('rule');
        if ($rule->getId()) {
            if (!$rule->hasData(RuleInterface::CUSTOMER_GROUP_IDS)) {
                $groupIds = $this->getCustomerGroupIdsByRuleId->execute((int)$rule->getId());
                $rule->setData(RuleInterface::CUSTOMER_GROUP_IDS, $groupIds);
            }
        }
    }
}
