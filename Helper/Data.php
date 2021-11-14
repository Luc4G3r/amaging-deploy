<?php
declare(strict_types=1);

namespace Luc4Ger\AmagingDeploy\Helper;

use DateTime;
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
    /**
     * schedule time
     *
     * used for deploy, as well as maintenance display
     */
    public const SCHEDULED_AT = 'scheduled_at';
    /** time of last deploy */
    private const LAST_DEPLOY = 'last_deploy';
    /** default value of deploy mode */
    private const DEFAULT_DEPLOY_MODE = 'default_deploy_mode';
    /** deploy mode */
    private const MODE = 'mode';
    /** state of current deploy */
    private const CURRENT_STATE = 'current_state';
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
    private ?bool $isEnabled = null;
    private ?bool $isScheduled = null;
    private ?int $currentState = null;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        WriterInterface $configWriter
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->configWriter = $configWriter;
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

    public function getCurrentState(): int
    {
        if (null === $this->currentState) {
            $this->currentState = (int) $this->scopeConfig->getValue(
                self::SETTINGS_PATH . self::CURRENT_STATE,
                ScopeConfigInterface::SCOPE_TYPE_DEFAULT
            );
        }
        return $this->currentState;
    }

    public function setCurrentState(int $state): void
    {
        $this->configWriter->save(
            self::SETTINGS_PATH . self::CURRENT_STATE,
            $state
        );
    }

    public function getScheduledAt(): ?DateTime
    {
        $scheduledAt = $this->scopeConfig->getValue(
            self::SETTINGS_PATH . self::SCHEDULED_AT,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT
        );
        try {
            return new DateTime($scheduledAt);
        } catch (\Exception $exception) {
            // TODO
            //  log this (WARNING)
            return null;
        }
    }
}
