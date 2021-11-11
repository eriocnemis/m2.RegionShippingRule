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
use Magento\Framework\Exception\LocalizedException;
use Eriocnemis\RegionShippingRule\Api\GetRuleIdsByRegionIdInterface;

/**
 * Load rules observer
 */
class LoadRuleObserver implements ObserverInterface
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
     * @var GetRuleIdsByRegionIdInterface
     */
    private $getRuleIdsByRegionId;

    /**
     * Initialize observer
     *
     * @param GetRuleIdsByRegionIdInterface $getRuleIdsByRegionId
     */
    public function __construct(
        GetRuleIdsByRegionIdInterface $getRuleIdsByRegionId
    ) {
        $this->getRuleIdsByRegionId = $getRuleIdsByRegionId;
    }

    /**
     * Load relation data
     *
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     */
    public function execute(Observer $observer): void
    {
        $region = $observer->getEvent()->getData('region');
        if ($region->getId()) {
            /** @var mixed[] $extensionAttributes */
            $extensionAttributes = (array)$region->getData(self::EXTENSION_ATTRIBUTES);
            $extensionAttributes[self::ATTRIBUTE] = $this->getRuleIdsByRegionId->execute(
                (int)$region->getId()
            );
            $region->setData(self::EXTENSION_ATTRIBUTES, $extensionAttributes);
        }
    }
}
