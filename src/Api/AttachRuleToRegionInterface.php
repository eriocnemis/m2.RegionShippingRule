<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Api;

use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Attach rule to region interface
 *
 * @api
 */
interface AttachRuleToRegionInterface
{
    /**
     * Attach rules
     *
     * @param int[] $ruleIds
     * @param int $regionId
     * @return void
     * @throws CouldNotSaveException
     */
    public function execute(array $ruleIds, int $regionId): void;
}
