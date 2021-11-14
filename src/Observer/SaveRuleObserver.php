<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Eriocnemis\RegionShippingRule\Api\DetachRuleFromRegionInterface;
use Eriocnemis\RegionShippingRule\Api\AttachRuleToRegionInterface;

/**
 * Save rules observer
 */
class SaveRuleObserver implements ObserverInterface
{
    /**
     * Extension attributes key
     */
    private const EXTENSION_ATTRIBUTES = ExtensibleDataInterface::EXTENSION_ATTRIBUTES_KEY;

    /**
     * Extension attribute name
     */
    private const ATTRIBUTE = 'shipping_rule_ids';

    /**
     * @var DetachRuleFromRegionInterface
     */
    private $detachRuleFromRegion;

    /**
     * @var AttachRuleToRegionInterface
     */
    private $attachRuleToRegion;

    /**
     * Initialize observer
     *
     * @param DetachRuleFromRegionInterface $detachRuleFromRegion
     * @param AttachRuleToRegionInterface $attachRuleToRegion
     */
    public function __construct(
        DetachRuleFromRegionInterface $detachRuleFromRegion,
        AttachRuleToRegionInterface $attachRuleToRegion
    ) {
        $this->detachRuleFromRegion = $detachRuleFromRegion;
        $this->attachRuleToRegion = $attachRuleToRegion;
    }

    /**
     * Save relation data
     *
     * @param Observer $observer
     * @return void
     * @throws CouldNotSaveException
     * @throws CouldNotDeleteException
     */
    public function execute(Observer $observer): void
    {
        $region = $observer->getEvent()->getData('region');
        if ($region->getId()) {
            /** @var mixed[] $extensionAttributes */
            $extensionAttributes = $region->getData(self::EXTENSION_ATTRIBUTES);
            $regionIds = $extensionAttributes[self::ATTRIBUTE] ?? [];
            $this->detachRuleFromRegion->execute((int)$region->getId());
            $this->attachRuleToRegion->execute($regionIds, (int)$region->getId());
        }
    }
}
