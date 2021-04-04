<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\Rule;

use Magento\Framework\Validation\ValidationResult;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;

/**
 * Extension point for base validation of rule
 *
 * @api
 */
interface ValidatorInterface
{
    /**
     * Validate rule attribute values
     *
     * @param RuleInterface $rule
     * @return ValidationResult
     */
    public function validate(RuleInterface $rule): ValidationResult;
}
