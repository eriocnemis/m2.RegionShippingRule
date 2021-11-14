<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Api;

use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Attach shipping methods to rule
 *
 * @api
 */
interface AttachMethodToRuleInterface
{
    /**
     * Attach shipping methods
     *
     * @param string[] $methods
     * @param int $ruleId
     * @return void
     * @throws CouldNotSaveException
     */
    public function execute(array $methods, int $ruleId): void;
}
