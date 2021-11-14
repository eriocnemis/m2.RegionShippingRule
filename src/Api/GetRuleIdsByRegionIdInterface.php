<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Api;

use Magento\Framework\Exception\LocalizedException;

/**
 * Get active rule ids by region id interface
 *
 * @api
 */
interface GetRuleIdsByRegionIdInterface
{
    /**
     * Retrieve rule ids by region id
     *
     * @param int $regionId
     * @return int[]
     * @throws LocalizedException
     */
    public function execute($regionId): array;
}
