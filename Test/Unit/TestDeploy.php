<?php
declare(strict_types=1);

namespace Luc4G3r\AmagingDeploy\Test\Unit;

use Luc4G3r\AmagingDeploy\Cron\Deploy;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

class TestDeploy extends TestCase
{
    protected ObjectManager $objectManager;
    protected object $model;

    public function tearDown(): void
    {
    }

    public function testExecute(): void
    {
        $this->assertTrue(true);
        //$this->expectError();
        /*
        if ($this->model instanceof Deploy) {
            throw new RuntimeException('Test subject was not created correctly.');
        }
        */
        $this->assertIsInt($result = $this->model->execute());
        $this->assertEquals(0, $result);
    }

    protected function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);
        $this->model = $this->objectManager->getObject(Deploy::class);
    }
}
