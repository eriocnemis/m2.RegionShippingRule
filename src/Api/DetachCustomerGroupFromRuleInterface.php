<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Api;

use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Detach customer groups from rule interface
 *
 * @api
 */
interface DetachCustomerGroupFromRuleInterface
{
    /**
     * Detach customer groups
     *
     * @param int $ruleId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $ruleId): void;
}
