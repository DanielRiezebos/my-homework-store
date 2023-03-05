<?php

declare(strict_types=1);

namespace Daniel\Routing\Controller;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;

class Router implements RouterInterface
{
    private const ROUTE_KEY = 'studyrouter';

    private ActionFactory $actionFactory;

    public function __construct(ActionFactory $actionFactory)
    {
        $this->actionFactory = $actionFactory;
    }

    public function match(RequestInterface $request): ?ActionInterface
    {
        if (strpos(trim($request->getPathInfo(), '/'), self::ROUTE_KEY) !== false) {
            $request->setModuleName('customrouter');
            $request->setControllerName('index');
            $request->setActionName('index');
            $request->setParams([
                'hello' => 'World',
                'lorem' => 'Ipsum'
            ]);

            return $this->actionFactory->create(Forward::class, ['request' => $request]);
        }

        return null;
    }
}
