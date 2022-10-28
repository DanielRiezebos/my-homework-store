<?php

declare(strict_types=1);

namespace Daniel\ProductHistory\Plugin;

use Magento\Catalog\Controller\Adminhtml\Product\Save;
use Daniel\ProductHistory\Model\ResourceModel\ProductHistoryFactory as ProductHistoryResourceFactory;
use Daniel\ProductHistory\Model\ProductHistoryFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Backend\Model\Auth\Session as AuthSession;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ResourceModel\ProductFactory as ProductResourceFactory;

class ProductChangeSave
{
    private ProductHistoryResourceFactory $productHistoryResourceFactory;
    private ProductHistoryFactory $productHistoryFactory;
    private RequestInterface $request;
    private ProductRepository $productRepository;
    private AuthSession $session;
    private RedirectFactory $redirectFactory;
    private ProductFactory $productFactory;
    private ProductResourceFactory $productResourceFactory;

    public function __construct(
        ProductHistoryResourceFactory $productHistoryResourceFactory,
        ProductHistoryFactory $productHistoryFactory,
        RequestInterface $request,
        ProductRepository $productRepository,
        AuthSession $session,
        RedirectFactory $redirectFactory,
        ProductFactory $productFactory,
        ProductResourceFactory $productResourceFactory
    ) {
        $this->productHistoryResourceFactory = $productHistoryResourceFactory;
        $this->productHistoryFactory = $productHistoryFactory;
        $this->request = $request;
        $this->productRepository = $productRepository;
        $this->session = $session;
        $this->redirectFactory = $redirectFactory;
        $this->productFactory = $productFactory;
        $this->productResourceFactory = $productResourceFactory;
    }

    public function aroundExecute(Save $subject, callable $proceed)
    {
        $writer = $this->productHistoryResourceFactory->create();
        $productId = $this->request->getParam('id');

        $oldProductData = $this->loadProductInformation($productId);
        $proceed();
        $newProductData = $this->loadProductInformation($productId);

        foreach ($oldProductData as $key => $value) {
            if ($value != $newProductData[$key]) {
                $moment = date('Y-m-d h:i:s');
                $user = $this->session->getUser()->getUserName();
                $writer->save(
                    $this->productHistoryFactory->create()->setMessage("On $moment $user changed $key from $value to $newProductData[$key] for product ID: $productId")
                );
            }
        }

        return $this->redirectFactory->create()->setPath('catalog/*/', ['store' => $this->request->getParam('store', 0)]);
    }

    private function loadProductInformation($productId): array
    {
        $productResource = $this->productResourceFactory->create();
        $productModel = $this->productFactory->create();

        $productResource->load($productModel, $productId);
        return $this->flattenArray(
            $productModel->getData()
        );
    }

    private function flattenArray($inputArray, $upperKey = null): array
    {
        $outputArray = [];

        foreach ($inputArray as $key => $value) {
            if (is_null($upperKey)) {
                $this->topLevel = $key;
            }

            if (is_array($value)) {
                $outputArray = array_merge($outputArray, $this->flattenArray($value, $key));
            } else {
                $outputArray[$key] = $value;
            }
        }

        return $outputArray;
    }
}
