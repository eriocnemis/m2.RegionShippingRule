<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\Rate\Validator;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Eriocnemis\RegionShippingRule\Model\Quote\QuoteContextInterface;
use Eriocnemis\RegionShippingRule\Model\Rate\ValidatorInterface;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleInterface;

/**
 * Customer group validator
 */
class CustomerGroupValidator implements ValidatorInterface
{
    /**
     * @var QuoteContextInterface
     */
    private $quoteContext;

    /**
     * Initialize validator
     *
     * @param QuoteContextInterface $quoteContext
     */
    public function __construct(
        QuoteContextInterface $quoteContext
    ) {
        $this->quoteContext = $quoteContext;
    }

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
        return in_array($this->getCustomerGroupId(), $rule->getCustomerGroupIds());
    }

    /**
     * Retrieve customer group id
     *
     * @return int
     */
    private function getCustomerGroupId()
    {
        return $this->quoteContext->getQuote()->getCustomerGroupId();
    }
}
