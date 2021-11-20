<?php
declare(strict_types=1);

namespace Luc4G3r\AmagingDeploy\Console\Component;

use Exception;
use Luc4Ger\AmagingDeploy\Helper\Data;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\ShellInterface;
use Magento\Framework\App\Shell;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use function sprintf;

class Deploy
{
    protected LoggerInterface $logger;
    private DirectoryList $directoryList;
    private Application $application;
    private Data $data;
    private ShellInterface $shell;

    public function __construct(
        DirectoryList $directoryList,
        Application $application,
        Data $data,
        Shell $shell,
        //ShellInterface $shell,
        LoggerInterface $logger
    ) {
        $this->directoryList = $directoryList;
        $this->application = $application;
        $this->data = $data;
        $this->shell = $shell;
        $this->logger = $logger;
    }

    /**
     * @return int
     *
     * @todo command line flags for magento deploy commands (load from system settings)
     */
    public function execute()
    {
        // load settings
        $enabled = $this->data->getIsEnabled();
        $scheduled = $this->data->getIsScheduled();

        if (!$enabled || !$scheduled) {
            return 0;
        }

        $currentState = $this->data->getCurrentState();

        if (0 === $currentState) {
            return $this->executeFirstStep();
        }

        if (1 === $currentState) {
            return $this->executeSecondStep();
        }

        if (2 === $currentState) {
            return $this->executeThirdStep();
        }

        $rootDir = $this->directoryList->getRoot();


        // TODO
        //  before return reset config values

        return 1;
        // TODO
        //  run deploy commands
        //  git
        //  composer -> needs script restart (
        //
    }

    protected function executeFirstStep(): int
    {
        $scheduledAt = $this->data->getScheduledAt();

        $this->logger->info('Starting deploy...');

        // TODO
        //  git pull
        //  composer install

        $this->data->setCurrentState(DATA::DEPLOY_STATE_RUNNING);
        return 0;
    }

    protected function executeSecondStep(): int
    {
        try {
            $output = $this->runMagentoCommand('setup:upgrade');

            sprintf('%s', $output->fetch());

            $output = $this->runMagentoCommand(
                'setup:di:compile',
                ['-f']
            );

            $this->logger->info(sprintf('%s', $output->fetch()));

            // TODO
            //  static content deploy

            //$this->logger->info($this->shell->execute('echo test'));
        } catch (Exception $exception) {
            $this->logger->emergency('The deploy was exited.');
            $this->logger->emergency($exception->getFile());
            $this->logger->emergency($exception->getMessage());
            $this->logger->emergency($exception->getTraceAsString());
            return 1;
        }

        return 0;
    }

    protected function executeThirdStep()
    {
        // TODO

        return 0;
    }

    /**
     * @param string $command
     * @param array $arguments
     * @return BufferedOutput
     * @throws Exception
     */
    private function runMagentoCommand(string $command, array $arguments = []): BufferedOutput
    {
        $input = new ArrayInput(array_merge(
            $arguments,
            [
                'command' => $command
            ]
        ));
        $output = new BufferedOutput();

        $this->application->run($input, $output);

        return $output;
    }
}
