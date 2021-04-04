<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\Rule;

use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;

/**
 * Rule composite validator
 */
class Validator implements ValidatorInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var ValidatorInterface[]
     */
    protected $validators;

    /**
     * Initialize validator
     *
     * @param ValidationResultFactory $validationResultFactory
     * @param ValidatorInterface[] $validators
     */
    public function __construct(
        ValidationResultFactory $validationResultFactory,
        array $validators = []
    ) {
        foreach ($validators as $validator) {
            if (!$validator instanceof ValidatorInterface) {
                throw new LocalizedException(
                    __('Rule validator must implement %1.', ValidatorInterface::class)
                );
            }
        }

        $this->validationResultFactory = $validationResultFactory;
        $this->validators = $validators;
    }

    /**
     * Validate rule attribute values
     *
     * @param RuleInterface $rule
     * @return ValidationResult
     */
    public function validate(RuleInterface $rule): ValidationResult
    {
        $errors = [];
        foreach ($this->validators as $validator) {
            $result = $validator->validate($rule);
            if (!$result->isValid()) {
                array_push($errors, ...$result->getErrors());
            }
        }
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
