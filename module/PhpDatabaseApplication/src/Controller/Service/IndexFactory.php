<?php

namespace PhpDatabaseApplication\Controller\Service;

use PhpDatabaseApplication\Controller\Index;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authenticationService = $serviceLocator->getServiceLocator()->get('application.authentication.service');

        return new Index($authenticationService);
    }
}
