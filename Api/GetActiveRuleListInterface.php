<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Api;

use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleSearchResultInterface;

/**
 * Find active rules by search criteria interface
 *
 * @api
 */
interface GetActiveRuleListInterface
{
    /**
     * Retrieve list of rules
     *
     * @param int[] $ruleIds
     * @return RuleSearchResultInterface
     */
    public function execute(array $ruleIds): RuleSearchResultInterface;
}
