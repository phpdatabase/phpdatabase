<?php

namespace PhpDatabaseMySQLTest\TaskService\Service;

use PhpDatabaseApplication\Authentication\AuthenticationService;
use PhpDatabaseApplication\Authentication\Connection\ConnectionInterface;
use PhpDatabaseMySQL\Metadata\MySQLMetadata;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceManager;

class AbstractServiceTestCase extends PHPUnit_Framework_TestCase
{
    public function createServiceManagerMock()
    {
        $metaData = $this->getMockForAbstractClass(MySQLMetadata::class, array(), '', false);

        $connection = $this->getMockForAbstractClass(ConnectionInterface::class);
        $connection->expects($this->once())->method('getMetaData')->willReturn($metaData);

        $authenticationService = $this->getMock(AuthenticationService::class);
        $authenticationService->expects($this->once())->method('getConnection')->willReturn($connection);

        $serviceManager = $this->getMock(ServiceManager::class);
        $invocation = $serviceManager->expects($this->once());
        $invocation->method('get');
        $invocation->with($this->equalTo('application.authentication.service'));
        $invocation->willReturn($authenticationService);

        return $serviceManager;
    }
}
