<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model;

use Magento\Framework\Validation\ValidationException;
use Magento\Framework\Validation\ValidationResult;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;
use Eriocnemis\RegionShippingRuleApi\Api\ValidateRuleInterface;
use Eriocnemis\RegionShippingRule\Model\Rule\ValidatorInterface;

/**
 * Validate rule data
 *
 * @api
 */
class ValidateRule implements ValidateRuleInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Initialize provider
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(
        ValidatorInterface $validator
    ) {
        $this->validator = $validator;
    }

    /**
     * Validate rule
     *
     * @param RuleInterface $rule
     * @return bool
     * @throws ValidationException
     */
    public function execute(RuleInterface $rule): bool
    {
        /** @var ValidationResult $result */
        $result = $this->validator->validate($rule);
        if (!$result->isValid()) {
            throw new ValidationException(__('Validation Failed'), null, 0, $result);
        }
        return true;
    }
}
