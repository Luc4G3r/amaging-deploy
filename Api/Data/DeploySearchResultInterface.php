<?php
declare(strict_types=1);

namespace Luc4G3r\AmagingDeploy\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface DeploySearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Luc4G3r\AmagingDeploy\Api\Data\DeployInterface[]
     */
    public function getItems();

    /**
     * @param \Luc4G3r\AmagingDeploy\Api\Data\DeployInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
