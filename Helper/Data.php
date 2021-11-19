<?php
declare(strict_types=1);

namespace Luc4Ger\AmagingDeploy\Helper;

use DateTime;
use Luc4G3r\AmagingDeploy\Api\Data\DeployInterface;
use Luc4G3r\AmagingDeploy\Model\DeployRepository;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;

class Data
{
    /** standard settings path */
    public const SETTINGS_PATH = 'amg_deploy/configuration/general/';
    /** is enabled */
    public const ENABLED = 'enabled';
    /** is scheduled */
    public const SCHEDULED = 'scheduled';
    /** default value of deploy mode */
    private const DEFAULT_DEPLOY_MODE = 'default_deploy_mode';
    /** deploy mode */
    private const MODE = 'mode';
    /** state of current deploy */
    private const INFO_MAIL = 'info_mail';
    private const REPORT_MAIL = 'report_mail';
    private const ERROR_MAIL = 'error_mail';
    private const MAINTENANCE_SHOW_TIME = 'maintenance_show_time';

    public const DEPLOY_STATE_STARTED = 0;
    public const DEPLOY_STATE_RUNNING = 1;
    public const DEPLOY_STATE_FINISHING = 2;
    public const DEPLOY_STATE_WAITING = 3;

    private ScopeConfigInterface $scopeConfig;
    private WriterInterface $configWriter;
    private DeployRepository $deployRepository;
    private ?bool $isEnabled = null;
    private ?bool $isScheduled = null;
    private ?DeployInterface $deploy = null;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        WriterInterface $configWriter,
        DeployRepository $deployRepository
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->configWriter = $configWriter;
        $this->deployRepository = $deployRepository;
    }

    public function getIsEnabled(): bool
    {
        if (null === $this->isEnabled) {
            $this->isEnabled = (bool) $this->scopeConfig->getValue(
                self::SETTINGS_PATH . self::ENABLED,
                ScopeConfigInterface::SCOPE_TYPE_DEFAULT
            );
        }
        return $this->isEnabled;
    }

    public function getIsScheduled(): bool
    {
        if (null === $this->isScheduled) {
            $this->isScheduled = (bool) $this->scopeConfig->getValue(
                self::SETTINGS_PATH . self::SCHEDULED,
                ScopeConfigInterface::SCOPE_TYPE_DEFAULT
            );
        }
        return $this->isScheduled;
    }

    public function getCurrentState(): ?int
    {
        $deploy = $this->getDeploy();

        return (null === $deploy) ? null : $deploy->getCurrentState();
    }

    private function getDeploy(): ?DeployInterface
    {
        if (null === $this->deploy) {
            $this->deploy = $this->getLatestDeploy();
        }
        return $this->deploy;
    }

    protected function getLatestDeploy(): ?DeployInterface
    {
        return $this->deployRepository->getLatest();
    }

    public function setCurrentState(int $state): void
    {
        $deploy = $this->getDeploy();

        if (null !== $deploy) {
            $deploy->setCurrentState($state);
        }
    }

    public function getScheduledAt(): ?DateTime
    {
        $deploy = $this->getDeploy();

        return (null === $deploy) ? null : $deploy->getScheduledAt();
    }
}
