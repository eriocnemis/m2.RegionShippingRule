<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\ResourceModel;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Eriocnemis\RegionShippingRule\Api\GetMethodsByRuleIdInterface;

/**
 * Get shipping methods by rule id
 */
class GetMethodsByRuleId implements GetMethodsByRuleIdInterface
{
    /**
     * Shipping methods relation table name
     */
    private const TABLE_NAME = 'eriocnemis_region_shipping_rule_method';

    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Initialize resource
     *
     * @param ResourceConnection $resource
     * @param LoggerInterface $logger
     */
    public function __construct(
        ResourceConnection $resource,
        LoggerInterface $logger
    ) {
        $this->resource = $resource;
        $this->logger = $logger;
    }

    /**
     * Retrieve shipping methods
     *
     * @param int $ruleId
     * @return string[]
     * @throws LocalizedException
     */
    public function execute(int $ruleId): array
    {
        $methods = [];
        try {
            $connection = $this->resource->getConnection();
            $select = $connection->select()->from(
                $this->resource->getTableName(self::TABLE_NAME),
                ['shipping_method']
            )->where('rule_id = ?', (string)$ruleId);

            $result = $connection->fetchCol($select);
            if ($result) {
                $methods = $result;
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new LocalizedException(
                __('Could not retrieve shipping methods by rule with id %id', ['id' => $ruleId])
            );
        }
        return $methods;
    }
}
