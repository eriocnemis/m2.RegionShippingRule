<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Plugin\Shipping\Model\Rate;

use Magento\Shipping\Model\Rate\Result;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Eriocnemis\RegionShippingRule\Model\Rate\Collector;
use Eriocnemis\RegionShippingRule\Model\Rate\Validator;
use Eriocnemis\RegionApi\Api\Data\RegionInterface;

/**
 * Result plugin
 */
class ResultPlugin
{
    /**
     * @var Collector
     */
    private $collector;

    /**
     * @var Validator
     */
    private $validator;

    /**
     * Initialize plugin
     *
     * @param Collector $collector
     * @param Validator $validator
     */
    public function __construct(
        Collector $collector,
        Validator $validator
    ) {
        $this->collector = $collector;
        $this->validator = $validator;
    }

    /**
     * Return all Rates in the Result
     *
     * @param Result $subject
     * @param Method[] $result
     * @return Method[]
     */
    public function afterGetAllRates(Result $subject, $result)
    {
        if (!$this->collector->getRules()) {
            return $result;
        };
        /* validate rates */
        foreach ($result ?: [] as $key => $rate) {
            if (false === $this->validate($rate)) {
                unset($result[$key]);
            }
        }
        return $result;
    }

    /**
     * Validate rate
     *
     * @param Method $rate
     * @return bool
     */
    private function validate(Method $rate): bool
    {
        foreach ($this->collector->getRules() as $rule) {
            $result = $this->validator->validate($rate, $rule, $this->collector->getRequest());
            if ($result) {
                return true;
            }
        }
        return false;
    }
}
