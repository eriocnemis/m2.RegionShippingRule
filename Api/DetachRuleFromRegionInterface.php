<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Api;

use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Detach rules from region interface
 *
 * @api
 */
interface DetachRuleFromRegionInterface
{
    /**
     * Detach rules
     *
     * @param int $regionId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $regionId): void;
}
