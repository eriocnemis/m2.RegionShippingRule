<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\Data;

use Magento\Framework\Api\SearchResults;
use Eriocnemis\RegionShippingRuleApi\Api\Data\RuleSearchResultInterface;

/**
 * Rule search result
 *
 * @api
 */
class RuleSearchResult extends SearchResults implements RuleSearchResultInterface
{
}
