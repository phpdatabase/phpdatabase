<?php

namespace PhpDatabaseApplication\Authentication\Service;

use PhpDatabaseApplication\Authentication\Adapter\AuthenticationAdapter;
use PhpDatabaseApplication\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $connectionManager = $serviceLocator->get('application.authentication.connectionpluginmanager');

        $adapter = new AuthenticationAdapter($connectionManager, $config['phpdatabase']['profiles']);

        $authenticationService = new AuthenticationService(null, $adapter);
        $authenticationService->setConnectionManager($connectionManager);

        return $authenticationService;
    }
}
