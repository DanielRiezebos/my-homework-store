<?php

declare(strict_types=1);

namespace Daniel\ConfigurationHistory\Model;

use Magento\Framework\Model\AbstractModel;
use Daniel\ConfigurationHistory\Model\ResourceModel\CoreConfigHistory as ResourceModel;

class CoreConfigHistory extends AbstractModel
{
    public const MESSAGE = 'message';

    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    public function setMessage(string $message): CoreConfigHistory
    {
        $this->setData(self::MESSAGE, $message);

        return $this;
    }
}
