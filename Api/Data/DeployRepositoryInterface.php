<?php
declare(strict_types=1);

namespace Luc4G3r\AmagingDeploy\Api\Data;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;

interface DeployRepositoryInterface
{
    /**
     * @param int $id
     * @return \Luc4G3r\AmagingDeploy\Api\Data\DeployInterface|null
     */
    public function getById(int $id): ?DeployInterface;

    /**
     * @param string $uuid
     * @return \Luc4G3r\AmagingDeploy\Api\Data\DeployInterface|null
     */
    public function getByUUID(string $uuid): ?DeployInterface;

    /**
     * @return \Luc4G3r\AmagingDeploy\Api\Data\DeployInterface|null
     */
    public function getLatest(): ?DeployInterface;

    /**
     * @param \Luc4G3r\AmagingDeploy\Api\Data\DeployInterface $deploy
     */
    public function save(DeployInterface $deploy): void;

    /**
     * @param \Luc4G3r\AmagingDeploy\Api\Data\DeployInterface $deploy
     */
    public function delete(DeployInterface $deploy): void;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return array
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults;
}
