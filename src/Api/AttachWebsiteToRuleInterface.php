<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Api;

use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Attach websites to rule
 *
 * @api
 */
interface AttachWebsiteToRuleInterface
{
    /**
     * Attach websites
     *
     * @param int[] $websiteIds
     * @param int $ruleId
     * @return void
     * @throws CouldNotSaveException
     */
    public function execute(array $websiteIds, int $ruleId): void;
}
