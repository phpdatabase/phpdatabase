<?php

namespace PhpDatabaseMongoDB\TaskService\Service;

use PhpDatabaseMongoDB\TaskService\Api;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApiFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authenticationService = $serviceLocator->get('application.authentication.service');

        return new Api($authenticationService->getConnection()->getMetaData());
    }
}
