<?php

namespace PhpDatabaseMySQL\Controller\Service;

use PhpDatabaseMySQL\Controller\Table;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableTaskService = $serviceLocator->getServiceLocator()->get('mysql.taskservice.table');

        return new Table($tableTaskService);
    }
}
