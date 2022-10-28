<?php

declare(strict_types=1);

namespace Daniel\ProductHistory\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ProductHistory extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'catalog_product_entity_history_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('catalog_product_entity_history', 'entity_id');
        $this->_useIsObjectNew = true;
    }
}
