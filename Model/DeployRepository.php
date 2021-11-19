<?php
declare(strict_types=1);

namespace Luc4G3r\AmagingDeploy\Model;

use Luc4G3r\AmagingDeploy\Api\Data\DeployInterface;
use Luc4G3r\AmagingDeploy\Api\Data\DeployRepositoryInterface;
use Luc4G3r\AmagingDeploy\Api\Data\DeploySearchResultInterfaceFactory;
use Luc4G3r\AmagingDeploy\Model\DeployFactory;
use Luc4G3r\AmagingDeploy\Model\ResourceModel\Deploy\Collection;
use Luc4G3r\AmagingDeploy\Model\ResourceModel\Deploy\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Data\Collection as BaseCollection;

class DeployRepository implements DeployRepositoryInterface
{
    private DeployFactory $deployFactory;
    private CollectionFactory $collectionFactory;
    private DeploySearchResultInterfaceFactory $searchResultFactory;
    private ?Collection $collection = null;

    public function __construct(
        DeployFactory $deployFactory,
        CollectionFactory $collectionFactory,
        DeploySearchResultInterfaceFactory $searchResultInterfaceFactory
    ) {
        $this->deployFactory = $deployFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $searchResultInterfaceFactory;
    }


    public function getById(int $id): ?DeployInterface
    {
        $collection = $this->getCollection();

        return $collection->getItemById($id);
    }

    public function getByUUID(string $uuid): ?DeployInterface
    {
        $collection = $this->getCollection();

        $collection->addFieldToFilter(
            'uuid',
            ['eq' => $uuid]
        );

        return $collection->getFirstItem();
    }

    public function getLatest(): ?DeployInterface
    {
        $collection = $this->getCollection();

        $collection->addOrder(
            'id',
            BaseCollection::SORT_ORDER_DESC
        );

        return $collection->getFirstItem();
    }


    public function save(DeployInterface $deploy): void
    {
        $deploy->save();
    }

    public function delete(DeployInterface $deploy): void
    {
        $deploy->delete();
    }

    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection): void
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection): void
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection): void
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection): SearchResults
    {
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    private function getCollection(): Collection
    {
        if (null === $this->collection) {
            $this->collection = $this->collectionFactory->create();
        }
        return $this->collection;
    }
}
