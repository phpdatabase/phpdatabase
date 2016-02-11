<?php

namespace PhpDatabaseMongoDB\Controller\Service;

use PhpDatabaseMongoDB\Controller\Api;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApiFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $apiTaskService = $serviceLocator->getServiceLocator()->get('mongodb.taskservice.api');

        return new Api($apiTaskService);
    }
}
