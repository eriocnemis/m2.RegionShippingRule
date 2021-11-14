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
 * Convert rule model to data interface
 *
 * @api
 */
interface ConvertRuleToDataInterface
{
    /**
     * Convert rule to data
     *
     * @param AbstractModel $model
     * @return RuleInterface
     */
    public function execute(AbstractModel $model): RuleInterface;
}
