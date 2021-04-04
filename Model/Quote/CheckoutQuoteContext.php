<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\Quote;

use Magento\Checkout\Model\Session;

/**
 * Checkout quote context
 */
class CheckoutQuoteContext implements QuoteContextInterface
{
    /**
     * @var Session
     */
    private $session;

    /**
     * Initialize context
     *
     * @param Session $session
     */
    public function __construct(
        Session $session
    ) {
        $this->session = $session;
    }

    /**
     * Retrieve quote
     *
     * @return \Magento\Quote\Model\Quote
     */
    public function getQuote()
    {
        return $this->session->getQuote();
    }
}
