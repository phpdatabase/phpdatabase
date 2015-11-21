<?php

namespace PhpDatabaseMySQL\Controller\Service;

use PhpDatabaseMySQL\Controller\Schema;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SchemaFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $schemaTaskService = $serviceLocator->getServiceLocator()->get('mysql.taskservice.schema');

        return new Schema($schemaTaskService);
    }
}
