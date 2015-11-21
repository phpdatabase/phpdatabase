<?php

namespace PhpDatabaseMySQLTest\TaskService\Service;

use PhpDatabaseMySQL\TaskService\Schema;
use PhpDatabaseMySQL\TaskService\Service\SchemaFactory;

class SchemaFactoryTest extends AbstractServiceTestCase
{
    public function testCreateService()
    {
        // Arrange
        $factory = new SchemaFactory();
        $serviceManager = $this->createServiceManagerMock();

        // Act
        $result = $factory->createService($serviceManager);

        // Assert
        $this->assertInstanceOf(Schema::class, $result);
    }
}
