<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model;

use Magento\Framework\Model\AbstractModel;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterfaceFactory;
use Eriocnemis\RegionShippingRule\Api\ConvertRuleToDataInterface;

/**
 * Convert rule model to data
 */
class ConvertRuleToData implements ConvertRuleToDataInterface
{
    /**
     * @var RuleInterfaceFactory
     */
    private $ruleDataFactory;

    /**
     * Initialize converter
     *
     * @param RuleInterfaceFactory $ruleDataFactory
     */
    public function __construct(
        RuleInterfaceFactory $ruleDataFactory
    ) {
        $this->ruleDataFactory = $ruleDataFactory;
    }

    /**
     * Convert rule to data
     *
     * @param AbstractModel $model
     * @return RuleInterface
     */
    public function execute(AbstractModel $model): RuleInterface
    {
        return $this->ruleDataFactory->create(['data' => $model->getData()]);
    }
}
