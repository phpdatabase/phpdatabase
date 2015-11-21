<?php

namespace PhpDatabaseApplication\Authentication;

use PhpDatabaseApplication\Authentication\Service\ConnectionPluginManager;
use RuntimeException;
use Zend\Authentication\AuthenticationService as BaseAuthenticationService;

class AuthenticationService extends BaseAuthenticationService
{
    private $connectionManager;
    private $connection;

    public function setConnectionManager(ConnectionPluginManager $connectionManager)
    {
        $this->connectionManager = $connectionManager;
    }

    public function getConnection()
    {
        if (!$this->connection) {
            $identity = $this->getIdentity();

            if (!$this->connectionManager->has($identity['platform'])) {
                throw new RuntimeException(sprintf('There is no connection registered for platform "%s".', $identity['platform']));
            }

            $this->connection = $this->connectionManager->get($identity['platform'], $identity);
        }

        return $this->connection;;
    }
}
