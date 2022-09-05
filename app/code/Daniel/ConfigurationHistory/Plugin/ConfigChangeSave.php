<?php

declare(strict_types=1);

namespace Daniel\ConfigurationHistory\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Config\Controller\Adminhtml\System\Config\Save;
use Daniel\ConfigurationHistory\Model\CoreConfigHistoryFactory;
use Daniel\ConfigurationHistory\Model\ResourceModel\CoreConfigHistoryFactory as CoreConfigHistoryResourceFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Backend\Model\Auth\Session as AuthSession;
use Magento\Store\Model\StoreManagerInterface;

class ConfigChangeSave
{
    private CoreConfigHistoryFactory $coreConfigHistoryFactory;
    private CoreConfigHistoryResourceFactory $coreConfigHistoryResourceFactory;
    private ScopeConfigInterface $scopeConfig;
    private RedirectFactory $redirectFactory;
    private string $topLevel = '';
    private AuthSession $session;
    private StoreManagerInterface $storeManager;

    public function __construct(
        CoreConfigHistoryFactory $coreConfigHistoryFactory,
        CoreConfigHistoryResourceFactory $coreConfigHistoryResourceFactory,
        ScopeConfigInterface $scopeConfig,
        RedirectFactory $redirectFactory,
        AuthSession $session,
        StoreManagerInterface $storeManager
    ) {
        $this->coreConfigHistoryFactory = $coreConfigHistoryFactory;
        $this->coreConfigHistoryResourceFactory = $coreConfigHistoryResourceFactory;
        $this->scopeConfig = $scopeConfig;
        $this->redirectFactory = $redirectFactory;
        $this->session = $session;
        $this->storeManager = $storeManager;
    }

    /**
     * @throws AlreadyExistsException
     */
    public function aroundExecute(Save $subject, callable $proceed): Redirect
    {
        $writer = $this->coreConfigHistoryResourceFactory->create();

        $beforeSaveConfig = $this->flattenArray($this->scopeConfig->getValue());
        $proceed();
        $afterSaveConfig = $this->flattenArray($this->scopeConfig->getValue());

        foreach ($beforeSaveConfig as $key => $value) {
            if ($value != $afterSaveConfig[$key]) {
                $moment = date('Y-m-d h:i:s');
                $user = $this->session->getUser()->getUserName();
                $writer->save(
                    $this->coreConfigHistoryFactory->create()
                        ->setMessage("On $moment the user $user changed $key from '$value' to '$afterSaveConfig[$key]'")
                );
            }
        }

        return $this->redirectFactory->create()->setPath(
            'adminhtml/system_config/edit',
            [
                '_current' => ['section', 'website', 'store'],
                '_nosid' => true
            ]
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
                $outputArray[$this->topLevel . '/' . $upperKey . '/' . $key] = $value;
            }
        }

        return $outputArray;
    }
}
