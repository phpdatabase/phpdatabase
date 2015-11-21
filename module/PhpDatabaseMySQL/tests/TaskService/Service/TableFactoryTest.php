<?php

namespace PhpDatabaseMySQLTest\TaskService\Service;

use PhpDatabaseApplication\Authentication\AuthenticationService;
use PhpDatabaseMySQL\Authentication\Connection\MySQLConnection;
use PhpDatabaseMySQL\Metadata\MySQLMetadata;
use PhpDatabaseMySQL\TaskService\Service\TableFactory;
use PhpDatabaseMySQL\TaskService\Table;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceManager;

class MyPDO extends MySQLConnection
{
    public function __construct()
    {
    }
}

class TableFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        // Arrange
        $factory = new TableFactory();

        $metaData = $this->getMockForAbstractClass(MySQLMetadata::class, array(), '', false);

        $connection = $this->getMock(MyPDO::class);
        $connection->expects($this->once())->method('getMetaData')->willReturn($metaData);

        $authenticationService = $this->getMock(AuthenticationService::class);
        $authenticationService->expects($this->once())->method('getConnection')->willReturn($connection);

        $serviceManager = $this->getMock(ServiceManager::class);
        $invocation = $serviceManager->expects($this->once());
        $invocation->method('get');
        $invocation->with($this->equalTo('application.authentication.service'));
        $invocation->willReturn($authenticationService);

        // Act
        $result = $factory->createService($serviceManager);

        // Assert
        $this->assertInstanceOf(Table::class, $result);
    }
}
