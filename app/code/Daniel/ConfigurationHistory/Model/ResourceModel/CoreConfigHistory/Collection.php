<?php

declare(strict_types=1);

namespace Daniel\ConfigurationHistory\Model\ResourceModel\CoreConfigHistory;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Daniel\ConfigurationHistory\Model\CoreConfigHistory as Model;
use Daniel\ConfigurationHistory\Model\ResourceModel\CoreConfigHistory as ResourceModel;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
