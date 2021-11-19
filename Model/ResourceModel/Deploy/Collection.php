<?php
declare(strict_types=1);

namespace Luc4G3r\AmagingDeploy\Model\ResourceModel\Deploy;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Luc4G3r\AmagingDeploy\Model\Deploy::class,
            Deploy::class
        );
    }


}
