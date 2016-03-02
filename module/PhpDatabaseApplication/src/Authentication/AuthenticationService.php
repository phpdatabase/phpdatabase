<?php

namespace PhpDatabaseApplication\Authentication;

use ArrayObject;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\AuthenticationService as BaseAuthenticationService;
use Zend\Authentication\Storage\StorageInterface;
use Zend\Session\Container;

class AuthenticationService extends BaseAuthenticationService
{
    private $container;

    public function __construct(StorageInterface $storage, AdapterInterface $adapter, Container $container)
    {
        parent::__construct($storage, $adapter);

        $this->container = $container;

        if (!$this->container->profiles) {
            $this->container->profiles = new ArrayObject();
        }
    }

    public function getIdentity()
    {
        if (!$this->hasIdentity()) {
            return null;
        }

        $identity = new Identity();

        foreach ($this->container->profiles as $data) {
            $identity->addProfile(new Profile(
                $data['name'],
                $data['display_name'],
                $data['platform'],
                $data['hostname'],
                $data['port'],
                $data['username'],
                $data['password']
            ));
        }

        return $identity;
    }

    public function clearConnection($index)
    {
        if (array_key_exists($index, $this->container->profiles)) {
            unset($this->container->profiles[$index]);
        }
    }

    public function clearIdentity()
    {
        $result = parent::clearIdentity();

        $this->container->profiles = [];

        return $result;
    }

    public function hasIdentity()
    {
        return count($this->container->profiles) !== 0;
    }

    public function authenticate(AdapterInterface $adapter = null)
    {
        $profiles = $this->container->profiles;

        $result = parent::authenticate($adapter);

        if ($result->isValid()) {
            $this->getStorage()->write(true);

            $this->container->profiles = $profiles;
            $this->container->profiles[] = $result->getIdentity();
        }

        return $result;
    }
}
