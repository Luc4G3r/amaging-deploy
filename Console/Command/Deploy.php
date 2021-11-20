<?php
declare(strict_types=1);

namespace Luc4Ger\AmagingDeploy\Console\Command;

use Luc4G3r\AmagingDeploy\Console\Component\Deploy as DeployComponent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Deploy extends Command
{
    private DeployComponent $deploy;

    public function __construct(
        DeployComponent $deploy,
        string $name = null
    )
    {
        $this->deploy = $deploy;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('luc4g3r:amg-deploy:run');
        $this->setDescription('Run deploy with current module configuration.');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Running deploy now...');
        $this->deploy->execute();
    }
}
