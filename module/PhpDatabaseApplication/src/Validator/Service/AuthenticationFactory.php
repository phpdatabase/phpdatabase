<?php

namespace PhpDatabaseApplication\Validator\Service;

use PhpDatabaseApplication\Validator\Authentication;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authenticationService = $serviceLocator->getServiceLocator()->get('application.authentication.service');

        $validator = new Authentication($authenticationService);
        $validator->setAuthenticationService($authenticationService);

        return $validator;
    }
}
