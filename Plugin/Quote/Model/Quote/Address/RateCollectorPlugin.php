<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Plugin\Quote\Model\Quote\Address;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateCollectorInterface;
use Eriocnemis\RegionShippingRule\Model\Rate\Collector;

/**
 * Rate collector plugin
 */
class RateCollectorPlugin
{
    /**
     * @var Collector
     */
    private $collector;

    /**
     * Initialize plugin
     *
     * @param Collector $collector
     */
    public function __construct(
        Collector $collector
    ) {
        $this->collector = $collector;
    }

    /**
     * Retrieve all methods for supplied shipping data
     *
     * @param RateCollectorInterface $subject
     * @param RateRequest $request
     * @return null
     */
    public function beforeCollectRates(RateCollectorInterface $subject, RateRequest $request)
    {
        $this->collector->collectRates($request);

        return null;
    }
}
