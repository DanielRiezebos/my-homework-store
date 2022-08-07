<?php

declare(strict_types=1);

namespace Daniel\ConfigurationHistory\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CoreConfigHistory extends AbstractDb
{
    public const TABLE_NAME = 'core_config_history';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'entity_id');
    }
}
