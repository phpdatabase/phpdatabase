<?php

namespace PhpDatabaseMongoDB\Metadata;

use MongoDB\Driver\Command;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use PhpDatabaseMongoDB\Authentication\Connection\MongoDBConnection;
use PhpDatabaseSchema\Metadata\NoSql\NoSqlMetadataInterface;
use PhpDatabaseSchema\Metadata\NoSql\Object\SchemaObject;


class MongoDBMetadata implements NoSqlMetadataInterface
{
    /**
     * @var MongoDBConnection
     */
    private $connection;

    /**
     * @var Manager
     */
    private $manager;

    public function __construct(MongoDBConnection $connection)
    {
        $this->connection = $connection;
        $this->manager = $this->connection->getManager();
    }

    public function getBuildInfo($databaseName)
    {
        $cursor = $this->manager->executeCommand($databaseName, new Command(['buildinfo' => 1]));
        $items = $cursor->toArray();

        return (array)$items[0];
    }

    public function getCommands()
    {
        $cursor = $this->manager->executeCommand('admin', new Command(['listCommands' => 1]));
        $cursorArray = $cursor->toArray();

        $commands = $cursorArray[0]->commands;

        foreach ($commands as $name => $command) {
            if ($name[0] === '_' || $command->help === 'internal') {
                continue;
            }
            var_dump($name);
            var_dump($command);
        }

        exit;

        return (array)$items[0];
    }

    public function getCollections($databaseName)
    {
        $cursor = $this->manager->executeQuery($databaseName . '.system.namespaces', new Query([]));

        $result = [];
        foreach ($cursor->toArray() as $item) {
            if (!preg_match('/^' . $databaseName . '\.([a-z0-9]+)$/i', $item->name, $matches)) {
                continue;
            }

            $result[] = $matches[1];
        }
        return $result;
    }

    public function createDatabase($name)
    {
        $cursor = $this->manager->executeQuery($name, new Query([]));

        var_dump($cursor);
        exit;
    }

    public function getDatabases()
    {
        $result = [];

        $cursor = $this->manager->executeCommand('admin', new Command(['listDatabases' => 1]));
        $data = $cursor->toArray();
        foreach ($data[0]->databases as $item) {
            $result[] = new SchemaObject($item->name, $item->sizeOnDisk, $item->empty);
        }

        return $result;
    }

    public function getServers()
    {
        return $this->manager->getServers();
    }
}
