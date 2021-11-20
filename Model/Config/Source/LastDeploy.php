<?php
declare(strict_types=1);

use Luc4G3r\AmagingDeploy\Model\DeployRepository;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class LastDeploy extends AbstractSource
{
    private DeployRepository $deployRepository;

    public function __construct(
        DeployRepository $deployRepository
    )
    {
        $this->deployRepository = $deployRepository;
    }


    public function getAllOptions(): ?array
    {
        $deploy = $this->deployRepository->getLatest();

        if (null !== $deploy && null !== $deploy->getFinishedAt()) {
            return [
                $deploy->getFinishedAt()
            ];
        }
        return null;
    }
}
