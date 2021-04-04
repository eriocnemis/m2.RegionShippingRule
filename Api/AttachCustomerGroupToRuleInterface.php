<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Api;

use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Attach customer groups to rule
 *
 * @api
 */
interface AttachCustomerGroupToRuleInterface
{
    /**
     * Attach customer groups
     *
     * @param int[] $customerGroupIds
     * @param int $ruleId
     * @return void
     * @throws CouldNotSaveException
     */
    public function execute(array $customerGroupIds, int $ruleId): void;
}
