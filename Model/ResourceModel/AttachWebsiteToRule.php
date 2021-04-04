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
use Eriocnemis\RegionShippingRule\Api\AttachWebsiteToRuleInterface;

/**
 * Attach websites to rule
 */
class AttachWebsiteToRule implements AttachWebsiteToRuleInterface
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
     * Attach websites
     *
     * @param int[] $websiteIds
     * @param int $ruleId
     * @return void
     * @throws CouldNotSaveException
     */
    public function execute(array $websiteIds, int $ruleId): void
    {
        try {
            $data = [];
            foreach ($websiteIds as $websiteId) {
                $data[] = [
                    'rule_id' => $ruleId,
                    'website_id' => $websiteId
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
                __('Could not attach website to rule with id %id', ['id' => $ruleId])
            );
        }
    }
}
