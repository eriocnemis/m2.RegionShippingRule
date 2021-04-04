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
use Eriocnemis\RegionShippingRule\Api\GetRuleIdsByRegionIdInterface;

/**
 * Get active rule ids by region id
 */
class GetRuleIdsByRegionId implements GetRuleIdsByRegionIdInterface
{
    /**
     * Rule relation table name
     */
    private const TABLE_NAME = 'eriocnemis_region_shipping_rule_relation';

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
     * Retrieve rule ids by region id
     *
     * @param int $regionId
     * @return int[]
     * @throws LocalizedException
     */
    public function execute($regionId): array
    {
        $ruleIds = [];
        try {
            $connection = $this->resource->getConnection();
            $select = $connection->select()->from(
                $this->resource->getTableName(self::TABLE_NAME),
                ['rule_id']
            )->where('region_id = ?', (string)$regionId);

            $result = $connection->fetchCol($select);
            if ($result) {
                $ruleIds = $result;
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new LocalizedException(
                __('Could not retrieve shipping rule ids by region with id %id', ['id' => $regionId])
            );
        }
        return $ruleIds;
    }
}
