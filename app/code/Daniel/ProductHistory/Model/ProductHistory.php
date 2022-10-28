<?php

declare(strict_types=1);

namespace Daniel\ProductHistory\Model;

use Daniel\ProductHistory\Model\ResourceModel\ProductHistory as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class ProductHistory extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'catalog_product_entity_history_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
