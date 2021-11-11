<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Api;

use Magento\Framework\Model\AbstractModel;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;

/**
 * Convert data to rule model interface
 *
 * @api
 */
interface ConvertDataToRuleInterface
{
    /**
     * Convert to model
     *
     * @param RuleInterface $rule
     * @return AbstractModel
     */
    public function execute(RuleInterface $rule): AbstractModel;
}
