<?php

namespace PhpDatabaseMySQL\TaskService\Service;

use PhpDatabaseMySQL\TaskService\Table;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authenticationService = $serviceLocator->get('application.authentication.service');

        $connection = $authenticationService->getConnection();
        $metaData = $connection->getMetadata();

        return new Table($connection, $metaData);
    }
}
