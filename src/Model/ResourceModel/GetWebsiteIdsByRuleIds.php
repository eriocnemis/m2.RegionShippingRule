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
use Eriocnemis\RegionShippingRule\Api\GetWebsiteIdsByRuleIdsInterface;

/**
 * Get website ids by rule ids
 */
class GetWebsiteIdsByRuleIds implements GetWebsiteIdsByRuleIdsInterface
{
    /**
     * Website relation table name
     */
    private const TABLE_NAME = 'eriocnemis_region_shipping_rule_website';

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
     * Retrieve website ids
     *
     * @param int[] $ruleIds
     * @return mixed[]
     * @throws LocalizedException
     */
    public function execute(array $ruleIds): array
    {
        $websiteIds = [];
        try {
            $connection = $this->resource->getConnection();
            $select = $connection->select()->from(
                $this->resource->getTableName(self::TABLE_NAME),
                ['rule_id', 'website_id']
            )->where('rule_id IN (?)', $ruleIds);

            $result = $connection->fetchAll($select);
            if ($result) {
                foreach ($result as $data) {
                    $websiteIds[$data['rule_id']][] = $data['website_id'];
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new LocalizedException(
                __('Could not retrieve website ids by rule ids')
            );
        }
        return $websiteIds;
    }
}
