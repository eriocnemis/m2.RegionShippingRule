<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Api;

use Magento\Framework\Exception\LocalizedException;

/**
 * Get website ids by rule id interface
 *
 * @api
 */
interface GetWebsiteIdsByRuleIdInterface
{
    /**
     * Retrieve website ids
     *
     * @param int $ruleId
     * @return int[]
     * @throws LocalizedException
     */
    public function execute(int $ruleId): array;
}
