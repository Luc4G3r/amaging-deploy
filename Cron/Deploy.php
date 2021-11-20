<?php
declare(strict_types=1);

namespace Luc4G3r\AmagingDeploy\Cron;

use Luc4G3r\AmagingDeploy\Console\Component\Deploy as DeployComponent;

class Deploy
{
    // TODO
    //  custom Logger and file

    private DeployComponent $deploy;

    public function __construct(
        DeployComponent $deploy
    )
    {
        $this->deploy = $deploy;
    }

    public function execute(): void
    {
        $this->deploy->execute();
    }
}
