<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model;

use Magento\Framework\Model\AbstractModel;
use Eriocnemis\RegionShippingRule\Model\ResourceModel\Rule as RuleResource;

/**
 * Rule model
 */
class Rule extends AbstractModel
{
    /**
     * Name prefix of events that are dispatched by model
     *
     * @var string
     */
    protected $_eventPrefix = 'eriocnemis_region_shipping_rule';

    /**
     * Name of event parameter
     *
     * @var string
     */
    protected $_eventObject = 'rule';

    /**
     * Model construct that should be used for object initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(RuleResource::class);
    }
}
