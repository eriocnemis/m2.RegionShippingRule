<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\Rate;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;

/**
 * Extension point for base validation of rate
 *
 * @api
 */
interface ValidatorInterface
{
    /**
     * Validate rate by request
     *
     * @param Method $rate
     * @param RuleInterface $rule
     * @param RateRequest $request
     * @return bool
     */
    public function validate(Method $rate, RuleInterface $rule, RateRequest $request): bool;
}
