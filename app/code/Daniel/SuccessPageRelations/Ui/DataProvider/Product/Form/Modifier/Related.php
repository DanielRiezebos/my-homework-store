<?php

declare(strict_types=1);

namespace Daniel\SuccessPageRelations\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Api\ProductLinkRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Related as Origin;
use Magento\Eav\Api\AttributeSetRepositoryInterface;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Form\Fieldset;

class Related extends Origin
{
    const DATA_SCOPE_SUCCESSPAGE = 'success_page';

    /**
     * @var string
     */
    private static $previousGroup = 'search-engine-optimization';

    /**
     * @var int
     */
    private static $sortOrder = 110;

    public function __construct(
        LocatorInterface $locator,
        UrlInterface $urlBuilder,
        ProductLinkRepositoryInterface $productLinkRepository,
        ProductRepositoryInterface $productRepository,
        ImageHelper $imageHelper,
        Status $status,
        AttributeSetRepositoryInterface $attributeSetRepository,
        $scopeName = '',
        $scopePrefix = ''
    ) {
        parent::__construct(
            $locator,
            $urlBuilder,
            $productLinkRepository,
            $productRepository,
            $imageHelper,
            $status,
            $attributeSetRepository,
            $scopeName,
            $scopePrefix
        );
    }

    /**
     * @inheritdoc
     *
     * @since 101.0.0
     */
    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                static::GROUP_RELATED => [
                    'children' => [
                        $this->scopePrefix . static::DATA_SCOPE_RELATED => $this->getRelatedFieldset(),
                        $this->scopePrefix . static::DATA_SCOPE_UPSELL => $this->getUpSellFieldset(),
                        $this->scopePrefix . static::DATA_SCOPE_CROSSSELL => $this->getCrossSellFieldset(),
                        $this->scopePrefix . static::DATA_SCOPE_SUCCESSPAGE => $this->getSuccessPageFieldset(

                        ),
                    ],
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Related Products, Up-Sells, Cross-Sells & Success Page relations'),
                                'collapsible' => true,
                                'componentType' => Fieldset::NAME,
                                'dataScope' => static::DATA_SCOPE,
                                'sortOrder' =>
                                    $this->getNextGroupSortOrder(
                                        $meta,
                                        self::$previousGroup,
                                        self::$sortOrder
                                    ),
                            ],
                        ],

                    ],
                ],
            ]
        );

        return $meta;
    }

    /**
     * Prepares config for the Cross-Sell products fieldset
     *
     * @return array
     * @since 101.0.0
     */
    protected function getSuccessPageFieldset()
    {
        $content = __(
            'These products appear on the success-page to stimulate' .
            ' customers to buy products related to this one.'
        );

        return [
            'children' => [
                'button_set' => $this->getButtonSet(
                    $content,
                    __('Add Success-Page Products'),
                    $this->scopePrefix . static::DATA_SCOPE_SUCCESSPAGE
                ),
                'modal' => $this->getGenericModal(
                    __('Add Success-Page Products'),
                    $this->scopePrefix . static::DATA_SCOPE_SUCCESSPAGE
                ),
                static::DATA_SCOPE_SUCCESSPAGE => $this->getGrid($this->scopePrefix . static::DATA_SCOPE_SUCCESSPAGE),
            ],
            'arguments' => [
                'data' => [
                    'config' => [
                        'additionalClasses' => 'admin__fieldset-section',
                        'label' => __('Success Page Products'),
                        'collapsible' => false,
                        'componentType' => Fieldset::NAME,
                        'dataScope' => '',
                        'sortOrder' => 30,
                    ],
                ],
            ]
        ];
    }

    /**
     * Retrieve all data scopes
     *
     * @return array
     * @since 101.0.0
     */
    protected function getDataScopes()
    {
        return [
            static::DATA_SCOPE_RELATED,
            static::DATA_SCOPE_CROSSSELL,
            static::DATA_SCOPE_UPSELL,
            static::DATA_SCOPE_SUCCESSPAGE,
        ];
    }
}
