<?php

namespace PhpDatabaseMongoDB\Metadata;

use MongoDB\Client;
use MongoDB\Database;
use MongoDB\Model\BSONDocument;
use MongoDB\Model\CollectionInfo;
use MongoDB\Model\DatabaseInfo;
use PhpDatabaseMongoDB\Authentication\Connection\MongoDBConnection;
use PhpDatabaseMongoDB\Paginator\Adapter\MongoDB;
use PhpDatabaseSchema\Metadata\NoSql\NoSqlMetadataInterface;
use PhpDatabaseSchema\Metadata\NoSql\Object\SchemaObject;
use Zend\Paginator\Paginator;

class MongoDBMetadata implements NoSqlMetadataInterface
{
    /**
     * @var MongoDBConnection
     */
    private $connection;

    /**
     * @var Client
     */
    private $client;

    public function __construct(MongoDBConnection $connection)
    {
        $this->connection = $connection;
        $this->client = $this->connection->getClient();
    }

    public function createCollection($databaseName, $collectionName)
    {
        /** @var Database $database */
        $database = $this->client->selectDatabase($databaseName);

        /** @var BSONDocument $result */
        $result = $database->createCollection($collectionName);

        return $result['ok'] == 1;
    }

    public function createDatabase($name)
    {
        /** @var Database $database */
        $database = $this->client->selectDatabase($name);
        $database->listCollections(); // Just so that the database will be created.

        return true;
    }

    public function dropCollection($databaseName, $collectionName)
    {
        /** @var Database $database */
        $database = $this->client->selectDatabase($databaseName);

        /** @var array $result */
        $result = (array)$database->dropCollection($collectionName);

        return $result['ok'] == 1;
    }

    public function dropDatabase($name)
    {
        /** @var BSONDocument $result */
        $result = $this->client->dropDatabase($name);

        return $result['ok'] == 1;
    }

    public function getBuildInfo()
    {
        /** @var Database $database */
        $database = $this->client->selectDatabase('admin');

        /** @var array $items */
        $items = $database->command(['buildinfo' => 1])->toArray();

        /** @var BSONDocument $document */
        $document = $items[0];

        $result = (array)$document;
        $result['versionArray'] = (array)$result['versionArray'];

        unset($result['ok']);

        return $result;
    }

    public function getCommands()
    {
        /** @var Database $database */
        $database = $this->client->selectDatabase('admin');

        /** @var array $items */
        $items = $database->command(['listCommands' => 1])->toArray();

        /** @var BSONDocument $document */
        $document = $items[0];

        /** @var BSONDocument $commandsDocument */
        $commandsDocument = $document->commands;

        $result = [];

        foreach ($commandsDocument as $name => $command) {
            $result[$name] = [
                'slaveOk' => $command->slaveOk,
                'slaveOverrideOk' => isset($command->slaveOverrideOk) ? $command->slaveOverrideOk : null,
                'adminOnly' => $command->adminOnly,
                'help' => $command->help,
            ];
        }

        return $result;
    }

    public function getCollectionPaginator($databaseName, $collectionName)
    {
        $adapter = new MongoDB($this->client, $databaseName, $collectionName);

        return new Paginator($adapter);
    }

    public function getCollections($databaseName)
    {
        /** @var Database $database */
        $database = $this->client->selectDatabase($databaseName);

        $collections = $database->listCollections();

        $result = [];

        /** @var CollectionInfo $item */
        foreach ($collections as $item) {
            $result[] = [
                'name' => $item->getName(),
                'cappedSize' => $item->getCappedSize(),
                'cappedMax' => $item->getCappedMax(),
            ];
        }

        return $result;
    }

    public function getDatabases()
    {
        $result = [];

        /** @var DatabaseInfo $item */
        foreach ($this->client->listDatabases() as $item) {
            $result[] = new SchemaObject($item->getName(), $item->getSizeOnDisk(), $item->isEmpty());
        }

        return $result;
    }
}
