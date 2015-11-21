<?php

namespace PhpDatabaseMySQL\Controller\Service;

use PhpDatabaseMySQL\Controller\Info;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InfoFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $schemaTaskService = $serviceLocator->getServiceLocator()->get('mysql.taskservice.info');

        return new Info($schemaTaskService);
    }
}
