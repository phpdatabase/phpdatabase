<?php

namespace PhpDatabaseMongoDB\TaskService;

use InvalidArgumentException;
use PhpDatabaseApplication\Exception\Api\PreconditionFailed;
use PhpDatabaseMongoDB\Metadata\MongoDBMetadata;

class Api
{
    private $metaData;

    public function __construct(MongoDBMetadata $metaData)
    {
        $this->metaData = $metaData;
    }

    public function getBuildInfo($databaseName)
    {
        return $this->metaData->getBuildInfo($databaseName);
    }

    public function getCommands()
    {
        return $this->metaData->getCommands();
    }

    public function getCollections($databaseName)
    {
        $data = [];
        foreach ($this->metaData->getCollections($databaseName) as $collection) {
            $data[] = [
                'name' => $collection,
            ];
        }
        return $data;
    }

    public function createDatabase($name)
    {
        if (!$name) {
            throw new PreconditionFailed('Missing the name of database to created.');
        }

        return [
            'success' => $this->metaData->createDatabase($name)
        ];
    }

    public function getDatabases()
    {
        $data = [];
        foreach ($this->metaData->getDatabases() as $database) {
            $data[] = [
                'name' => $database->getName(),
                'sizeOnDisk' => $database->getSizeOnDisk(),
                'empty' => $database->getEmpty(),
            ];
        }
        return $data;
    }

    public function getServers()
    {
        $data = [];
        foreach ($this->metaData->getServers() as $server) {
        }
        return $data;
    }
}
