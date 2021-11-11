<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\Rate\Validator;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Eriocnemis\RegionShippingRule\Model\Rate\ValidatorInterface;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;

/**
 * Method validator
 */
class MethodValidator implements ValidatorInterface
{
    /**
     * Validate rate
     *
     * @param Method $rate
     * @param RuleInterface $rule
     * @param RateRequest $request
     * @return bool
     */
    public function validate(Method $rate, RuleInterface $rule, RateRequest $request): bool
    {
        return $rule->getMethodsAccess() || in_array($this->getMethodName($rate), $rule->getShippingMethods());
    }

    /**
     * Retrieve the method name
     *
     * @param Method $rate
     * @return string
     */
    private function getMethodName(Method $rate): string
    {
        return $rate->getData('carrier') . '_' . $rate->getData('method');
    }
}
