<?php

declare(strict_types=1);

namespace Daniel\ProductHistory\Model\ResourceModel\ProductHistory;

use Daniel\ProductHistory\Model\ProductHistory as Model;
use Daniel\ProductHistory\Model\ResourceModel\ProductHistory as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'catalog_product_entity_history_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
