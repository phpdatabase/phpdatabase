<?php

namespace PhpDatabaseMongoDB\Metadata;

use MongoClient;
use PhpDatabaseSchema\Metadata\NoSql\NoSqlMetadataInterface;
use PhpDatabaseSchema\Metadata\NoSql\Object\SchemaObject;

class MongoDBMetadata implements NoSqlMetadataInterface
{
    private $client;

    public function __construct(MongoClient $client)
    {
        $this->client = $client;
    }

    public function getSchema($schemaName)
    {

    }

    public function getSchemas()
    {
        $databaseSet = $this->client->listDBs();

        $result = [];
        foreach ($databaseSet['databases'] as $database) {
            $schemaObject = new SchemaObject($database['name']);
            $schemaObject->setSizeOnDisk($database['sizeOnDisk']);
            $schemaObject->setEmpty($database['empty']);

            $result[] = $schemaObject;
        }
        return $result;
    }
}
