<?php

namespace PhpDatabaseApplication\Form\Service;

use PhpDatabaseApplication\Form\Authenticate;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticateFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->getServiceLocator()->get('Config');

        $form = new Authenticate();
        $form->setProfiles($config['phpdatabase']['profiles']);
        $form->setDisplayDefaultProfile($config['phpdatabase']['display_default_profile']);

        return $form;
    }
}
