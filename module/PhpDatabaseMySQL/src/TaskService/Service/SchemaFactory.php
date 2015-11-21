<?php

namespace PhpDatabaseMySQL\TaskService\Service;

use PhpDatabaseMySQL\TaskService\Schema;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SchemaFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authenticationService = $serviceLocator->get('application.authentication.service');

        return new Schema($authenticationService->getConnection()->getMetaData());
    }
}
