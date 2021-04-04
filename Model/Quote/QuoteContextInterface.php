<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\Quote;

/**
 * Quote context interface
 *
 * @api
 */
interface QuoteContextInterface
{
    /**
     * Retrieve quote
     *
     * @return \Magento\Quote\Model\Quote
     */
    public function getQuote();
}
