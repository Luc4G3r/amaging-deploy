<?php
declare(strict_types=1);

namespace Luc4G3r\AmagingDeploy\Model;

use DateTime;
use Luc4G3r\AmagingDeploy\Api\Data\DeployExtensionInterface;
use Luc4G3r\AmagingDeploy\Api\Data\DeployInterface;
use Luc4G3r\AmagingDeploy\Model\ResourceModel\Deploy\Deploy as DeployResource;
use Magento\Framework\Model\AbstractExtensibleModel;

class Deploy extends AbstractExtensibleModel implements DeployInterface
{
    private ?int $id;
    private ?string $uuid;
    private DateTime $scheduledAt;
    private DateTime $startedAt;
    private DateTime $finishedAt;
    private int $mode;
    private int $currentState;
    private ?bool $exited;
    private ?string $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUUID(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param string|null $uuid
     */
    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getScheduledAt(): DateTime
    {
        return $this->scheduledAt;
    }

    /**
     * @param DateTime $scheduledAt
     */
    public function setScheduledAt(DateTime $scheduledAt): void
    {
        $this->scheduledAt = $scheduledAt;
    }

    public function getStartedAt(): ?DateTime
    {
        return $this->startedAt;
    }

    /**
     * @param DateTime $startedAt
     */
    public function setStartedAt(DateTime $startedAt): void
    {
        $this->startedAt = $startedAt;
    }

    public function getFinishedAt(): ?DateTime
    {
        return $this->finishedAt;
    }

    /**
     * @param DateTime $finishedAt
     */
    public function setFinishedAt(DateTime $finishedAt): void
    {
        $this->finishedAt = $finishedAt;
    }

    public function getMode(): int
    {
        return $this->mode;
    }

    /**
     * @param int $mode
     */
    public function setMode(int $mode): void
    {
        $this->mode = $mode;
    }

    public function getCurrentState(): int
    {
        return $this->currentState;
    }

    public function setCurrentState(int $state): void
    {
        $this->currentState = $state;
    }


    public function getIsExited(): ?bool
    {
        return $this->exited;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param bool|null $exited
     */
    public function setExited(?bool $exited): void
    {
        $this->exited = $exited;
    }

    public function setIsExited(bool $exited): void
    {
        $this->exited = $exited;
    }

    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    public function setExtensionAttributes(DeployExtensionInterface $extensionAttributes)
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }

    protected function _construct()
    {
        $this->_init(DeployResource::class);
    }
}
