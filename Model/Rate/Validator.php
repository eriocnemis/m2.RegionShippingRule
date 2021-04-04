<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\Rate;

use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;

/**
 * Rate composite validator
 */
class Validator implements ValidatorInterface
{
    /**
     * @var ValidatorInterface[]
     */
    protected $validators;

    /**
     * Initialize validator
     *
     * @param ValidatorInterface[] $validators
     * @throws LocalizedException
     */
    public function __construct(
        array $validators = []
    ) {
        foreach ($validators as $validator) {
            if (!$validator instanceof ValidatorInterface) {
                throw new LocalizedException(
                    __('Rate validator must implement %1.', ValidatorInterface::class)
                );
            }
        }
        $this->validators = $validators;
    }

    /**
     * Validate rate by request
     *
     * @param Method $rate
     * @param RuleInterface $rule
     * @param RateRequest $request
     * @return bool
     */
    public function validate(Method $rate, RuleInterface $rule, RateRequest $request): bool
    {
        foreach ($this->validators as $validator) {
            $result = $validator->validate($rate, $rule, $request);
            if (!$result) {
                return false;
            }
        }
        return true;
    }
}
