<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Eriocnemis\RegionShippingRule\Api\DetachWebsiteFromRuleInterface;
use Eriocnemis\RegionShippingRule\Api\AttachWebsiteToRuleInterface;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;

/**
 * Save websites observer
 */
class SaveWebsiteObserver implements ObserverInterface
{
    /**
     * @var DetachWebsiteFromRuleInterface
     */
    private $detachWebsiteFromRule;

    /**
     * @var AttachWebsiteToRuleInterface
     */
    private $attachWebsiteToRule;

    /**
     * Initialize observer
     *
     * @param DetachWebsiteFromRuleInterface $detachWebsiteFromRule
     * @param AttachWebsiteToRuleInterface $attachWebsiteToRule
     */
    public function __construct(
        DetachWebsiteFromRuleInterface $detachWebsiteFromRule,
        AttachWebsiteToRuleInterface $attachWebsiteToRule
    ) {
        $this->detachWebsiteFromRule = $detachWebsiteFromRule;
        $this->attachWebsiteToRule = $attachWebsiteToRule;
    }

    /**
     * Save websites data
     *
     * @param Observer $observer
     * @return void
     * @throws CouldNotSaveException
     * @throws CouldNotDeleteException
     */
    public function execute(Observer $observer): void
    {
        $rule = $observer->getEvent()->getData('rule');
        if ($rule->getId()) {
            $websiteIds = $rule->hasData(RuleInterface::WEBSITE_IDS)
                ? $rule->getData(RuleInterface::WEBSITE_IDS)
                : [];
            $this->detachWebsiteFromRule->execute((int)$rule->getId());
            $this->attachWebsiteToRule->execute($websiteIds, (int)$rule->getId());
        }
    }
}
