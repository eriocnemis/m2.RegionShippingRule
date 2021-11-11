<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\RegionShippingRule\Model\ResourceModel;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotSaveException;
use Eriocnemis\RegionShippingRule\Api\AttachRuleToRegionInterface;

/**
 * Attach rule to region
 */
class AttachRuleToRegion implements AttachRuleToRegionInterface
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
     * Attach rules
     *
     * @param int[] $ruleIds
     * @param int $regionId
     * @return void
     * @throws CouldNotSaveException
     */
    public function execute(array $ruleIds, int $regionId): void
    {
        try {
            $data = [];
            foreach ($ruleIds as $ruleId) {
                $data[] = [
                    'region_id' => $regionId,
                    'rule_id' => $ruleId
                ];
            }

            if ($data) {
                $this->resource->getConnection()->insertOnDuplicate(
                    $this->resource->getTableName(self::TABLE_NAME),
                    $data
                );
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            throw new CouldNotSaveException(
                __('Could not attach shipping rules to region with id %id', ['id' => $regionId])
            );
        }
    }
}
