<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Api;

use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Detach websites from rule interface
 *
 * @api
 */
interface DetachWebsiteFromRuleInterface
{
    /**
     * Detach websites
     *
     * @param int $ruleId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $ruleId): void;
}
