<?php

declare(strict_types=1);

namespace Daniel\ConfigurationHistory\Model;

use Magento\Framework\Model\AbstractModel;
use \Daniel\ConfigurationHistory\Model\ResourceModel\CoreConfigHistory as ResourceModel;

class CoreConfigHistory extends AbstractModel
{
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
