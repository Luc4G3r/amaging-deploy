<?php
declare(strict_types=1);

namespace Luc4G3r\AmagingDeploy\Api\Data;

use DateTime;
use Magento\Framework\Api\ExtensibleDataInterface;

interface DeployInterface extends ExtensibleDataInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return string|null
     */
    public function getUUID(): ?string;

    /**
     * @param string|null $uuid
     */
    public function setUUID(?string $uuid): void;

    /**
     * @return DateTime
     */
    public function getScheduledAt(): DateTime;

    /**
     * @param DateTime $scheduledAt
     */
    public function setScheduledAt(DateTime $scheduledAt): void;

    /**
     * @return DateTime|null
     */
    public function getStartedAt(): ?DateTime;

    /**
     * @param DateTime $startedAt
     */
    public function setStartedAt(DateTime $startedAt): void;

    /**
     * @return DateTime|null
     */
    public function getFinishedAt(): ?DateTime;

    /**
     * @param DateTime $finishedAt
     */
    public function setFinishedAt(DateTime $finishedAt): void;

    /**
     * @return int
     */
    public function getMode(): int;

    /**
     * @param int $mode
     */
    public function setMode(int $mode): void;

    /**
     * @return int
     */
    public function getCurrentState(): int;

    /**
     * @param int $state
     */
    public function setCurrentState(int $state): void;

    /**
     * @return bool|null
     */
    public function getIsExited(): ?bool;

    public function setIsExited(bool $exited): void;

    /**
     * @return string|null
     */
    public function getMessage(): ?string;

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void;

    /**
     * @return mixed
     */
    public function getExtensionAttributes();

    /**
     * @param \Luc4G3r\AmagingDeploy\Api\Data\DeployExtensionInterface $extensionAttributes
     * @return mixed
     */
    public function setExtensionAttributes(DeployExtensionInterface $extensionAttributes);
}
