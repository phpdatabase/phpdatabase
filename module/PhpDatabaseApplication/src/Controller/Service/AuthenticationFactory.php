<?php

namespace PhpDatabaseApplication\Controller\Service;

use PhpDatabaseApplication\Controller\Authentication;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authenticationService = $serviceLocator->getServiceLocator()->get('application.authentication.service');

        $authenticateForm = $serviceLocator->getServiceLocator()->get('application.form.authenticate');

        return new Authentication($authenticationService, $authenticateForm);
    }
}
