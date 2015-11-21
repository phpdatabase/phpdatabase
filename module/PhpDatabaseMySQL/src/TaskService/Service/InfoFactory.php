<?php

namespace PhpDatabaseMySQL\TaskService\Service;

use PhpDatabaseMySQL\TaskService\Info;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InfoFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authenticationService = $serviceLocator->get('application.authentication.service');

        return new Info($authenticationService->getConnection()->getMetaData());
    }
}
