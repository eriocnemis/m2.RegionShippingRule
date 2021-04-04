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
use Eriocnemis\RegionShippingRule\Api\GetWebsiteIdsByRuleIdInterface;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;

/**
 * Load website ids observer
 */
class LoadWebsiteObserver implements ObserverInterface
{
    /**
     * @var GetWebsiteIdsByRuleIdInterface
     */
    private $getWebsiteIdsByRuleId;

    /**
     * Initialize observer
     *
     * @param GetWebsiteIdsByRuleIdInterface $getWebsiteIdsByRuleId
     */
    public function __construct(
        GetWebsiteIdsByRuleIdInterface $getWebsiteIdsByRuleId
    ) {
        $this->getWebsiteIdsByRuleId = $getWebsiteIdsByRuleId;
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
        $rule = $observer->getEvent()->getData('rule');
        if ($rule->getId()) {
            if (!$rule->hasData(RuleInterface::WEBSITE_IDS)) {
                $websiteIds = $this->getWebsiteIdsByRuleId->execute((int)$rule->getId());
                $rule->setData(RuleInterface::WEBSITE_IDS, $websiteIds);
            }
        }
    }
}
