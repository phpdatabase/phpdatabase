<?php

namespace PhpDatabaseApplication;

use Zend\Http\Response;
use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onCheckAuthentication'), 10);
    }

    public function onCheckAuthentication(MvcEvent $e)
    {
        $authenticationService = $e->getApplication()->getServiceManager()->get('application.authentication.service');

        if (!$authenticationService->hasIdentity() && $e->getRouteMatch()->getMatchedRouteName() !== 'login') {
            $response = $e->getResponse();
            $response->setStatusCode(Response::STATUS_CODE_302);

            $headers = $response->getHeaders();
            $headers->addHeaderLine('Location: ' . $e->getRouter()->assemble([], ['name' => 'login']));

            return $response;
        }
    }
}
