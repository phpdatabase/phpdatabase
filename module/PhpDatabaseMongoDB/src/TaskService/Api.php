<?php

namespace PhpDatabaseMongoDB\TaskService;

use PhpDatabaseApplication\Exception\Api\PreconditionFailed;
use PhpDatabaseMongoDB\Metadata\MongoDBMetadata;

class Api
{
    private $metaData;

    public function __construct(MongoDBMetadata $metaData)
    {
        $this->metaData = $metaData;
    }

    public function createCollection($databaseName, $collectionName)
    {
        if (!$databaseName) {
            throw new PreconditionFailed('Missing the name of database to create the collection in.');
        }

        if (!$collectionName) {
            throw new PreconditionFailed('Missing the name of collection to create.');
        }

        return $this->metaData->createCollection($databaseName, $collectionName);
    }

    public function createDatabase($name)
    {
        if (!$name) {
            throw new PreconditionFailed('Missing the name of database to create.');
        }

        return [
            'success' => $this->metaData->createDatabase($name)
        ];
    }

    public function dropCollection($databaseName, $collectionName)
    {
        if (!$databaseName) {
            throw new PreconditionFailed('Missing the name of database to drop the collection in.');
        }

        if (!$collectionName) {
            throw new PreconditionFailed('Missing the name of collection to drop.');
        }

        return $this->metaData->dropCollection($databaseName, $collectionName);
    }

    public function dropDatabase($name)
    {
        if (!$name) {
            throw new PreconditionFailed('Missing the name of database to be dropped.');
        }

        return [
            'success' => $this->metaData->dropDatabase($name)
        ];
    }

    public function getBuildInfo()
    {
        return $this->metaData->getBuildInfo();
    }

    public function getCommands()
    {
        return $this->metaData->getCommands();
    }

    public function getCollection($databaseName, $collectionName)
    {
        return $this->metaData->getCollectionPaginator($databaseName, $collectionName);
    }

    public function getCollections($databaseName)
    {
        if (!$databaseName) {
            throw new PreconditionFailed('Missing the "database" query parameter.');
        }

        return $this->metaData->getCollections($databaseName);
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
}
