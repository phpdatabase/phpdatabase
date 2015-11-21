<?php

namespace PhpDatabaseMySQLTest\TaskService\Service;

use PhpDatabaseMySQL\TaskService\Info;
use PhpDatabaseMySQL\TaskService\Service\InfoFactory;

class InfoFactoryTest extends AbstractServiceTestCase
{
    public function testCreateService()
    {
        // Arrange
        $factory = new InfoFactory();
        $serviceManager = $this->createServiceManagerMock();

        // Act
        $result = $factory->createService($serviceManager);

        // Assert
        $this->assertInstanceOf(Info::class, $result);
    }
}
