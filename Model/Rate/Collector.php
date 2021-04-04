<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\Rate;

use Psr\Log\LoggerInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;
use Eriocnemis\RegionShippingRule\Api\GetActiveRuleListInterface;
use Eriocnemis\RegionApi\Api\GetRegionByIdInterface;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;

/**
 * Rate collector
 */
class Collector
{
    /**
     * @var RateRequest
     */
    private $request;

    /**
     * @var RegionInterface|null
     */
    private $region;

    /**
     * @var GetRegionByIdInterface
     */
    private $getRegionById;

    /**
     * @var GetActiveRuleListInterface
     */
    private $getActiveRuleList;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var RuleInterface[]
     */
    private $rules = [];

    /**
     * Initialize collector
     *
     * @param GetRegionByIdInterface $getRegionById
     * @param GetActiveRuleListInterface $getActiveRuleList
     * @param LoggerInterface $logger
     */
    public function __construct(
        GetRegionByIdInterface $getRegionById,
        GetActiveRuleListInterface $getActiveRuleList,
        LoggerInterface $logger
    ) {
        $this->getRegionById = $getRegionById;
        $this->getActiveRuleList = $getActiveRuleList;
        $this->logger = $logger;
    }

    /**
     * Collect rates
     *
     * @param RateRequest $request
     * @return void
     */
    public function collectRates(RateRequest $request)
    {
        $regionId = $request->getDestRegionId();
        if (!$regionId) {
            $this->reset();
            return;
        }

        $this->request = $request;
        if ($this->region instanceof RegionInterface &&
            $this->region->getId() == $regionId
        ) {
            return;
        }

        try {
            $this->rules = [];
            $this->region = $this->getRegionById->execute((int)$regionId);
            $extensionAttributes = $this->region->getExtensionAttributes();
            $ruleIds = $extensionAttributes->getShippingRuleIds() ?: [];

            if ($ruleIds) {
                $searchResult = $this->getActiveRuleList->execute($ruleIds);
                if (0 < $searchResult->getTotalCount()) {
                    $this->rules = $searchResult->getItems();
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Reset collector
     *
     * @return void
     */
    public function reset()
    {
        $this->region = null;
        $this->rules = [];
    }

    /**
     * Retrieve shipping rules
     *
     * @return RuleInterface[]
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Retrieve rate request
     *
     * @return RateRequest
     */
    public function getRequest()
    {
        return $this->request;
    }
}
