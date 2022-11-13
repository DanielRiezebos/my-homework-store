<?php

declare(strict_types=1);

namespace Daniel\Duckonversions\Setup;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Product;
use Zend_Validate_Exception;

class InstallData implements InstallDataInterface
{
    private EavSetupFactory $eavSetupFactory;
    public const ATTRIBUTE_CODE = 'ducks';

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @throws Zend_Validate_Exception
     * @throws LocalizedException
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CODE,
            [
                'type' => 'decimal',
                'input' => 'text',
                'group' => 'General',
                'label' => 'Weight in Ducks',
                'system' => false,
                'backend' => 'Magento\Catalog\Model\Product\Attribute\Backend\Weight',
                'frontend' => '',
                'source' => '',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'is_used_in_grid' => true,
                'visible_on_front' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'used_in_product_listing' => true,
                'sort_order' => 42
            ]
        );
    }
}
