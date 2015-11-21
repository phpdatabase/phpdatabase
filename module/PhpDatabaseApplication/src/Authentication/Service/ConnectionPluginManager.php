<?php

namespace PhpDatabaseApplication\Authentication\Service;

use InvalidArgumentException;
use PhpDatabaseApplication\Authentication\Connection\ConnectionInterface;
use Zend\ServiceManager\AbstractPluginManager;

class ConnectionPluginManager extends AbstractPluginManager
{
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof ConnectionInterface) {
            throw new InvalidArgumentException(sprintf(
                'Plugin of type %s is invalid; must implement %s',
                is_object($plugin) ? get_class($plugin) : gettype($plugin),
                ConnectionInterface::class
            ));
        }
    }
}
