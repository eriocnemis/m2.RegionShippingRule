<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Api;

use Magento\Framework\Exception\LocalizedException;

/**
 * Get shipping methods by rule id interface
 *
 * @api
 */
interface GetMethodsByRuleIdsInterface
{
    /**
     * Retrieve shipping methods
     *
     * @param int[] $ruleIds
     * @return mixed[]
     * @throws LocalizedException
     */
    public function execute(array $ruleIds): array;
}
