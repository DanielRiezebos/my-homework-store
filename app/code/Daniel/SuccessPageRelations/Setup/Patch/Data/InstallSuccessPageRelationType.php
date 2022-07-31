<?php

declare(strict_types=1);

namespace Daniel\SuccessPageRelations\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Daniel\SuccessPageRelations\Model\Product\Link;

class InstallSuccessPageRelationType implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    public const SUCCES_PAGE_CODE = 'success_page';

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /** Install success_page link type */
        $this->moduleDataSetup->getConnection()->insertForce(
            $this->moduleDataSetup->getTable(
                'catalog_product_link_type'
            ),
            ['link_type_id' => Link::LINK_TYPE_SUCCESSPAGE, 'code' => self::SUCCES_PAGE_CODE]
        );

        /** Insert success_page attributes */
        $this->moduleDataSetup->getConnection()->insertForce(
            $this->moduleDataSetup->getTable('catalog_product_link_attribute'),
            [
                'link_type_id' => Link::LINK_TYPE_SUCCESSPAGE,
                'product_link_attribute_code' => 'position',
                'data_type' => 'int'
            ]
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }


    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheirtDoc
     */
    public function getAliases()
    {
        return [];
    }
}
