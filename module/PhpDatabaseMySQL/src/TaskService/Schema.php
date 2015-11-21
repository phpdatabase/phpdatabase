<?php

namespace PhpDatabaseMySQL\TaskService;

use PhpDatabaseMySQL\Metadata\MySQLMetadata;
use PhpDatabaseSchema\Metadata\Relational\Object\SchemaObject;

class Schema
{
    private $metaData;

    public function __construct(MySQLMetadata $metaData)
    {
        $this->metaData = $metaData;
    }

    private function buildData(SchemaObject $schema)
    {
        return [
            'name' => $schema->getName(),
            'characterSetName' => $schema->getDefaultCharacterSetName(),
            'collationName' => $schema->getDefaultCollationName(),
        ];
    }

    public function getSchemaData($schemaName)
    {
        /* @var $data SchemaObject */
        $data = $this->metaData->getSchema($schemaName);

        if (!$data) {
            return null;
        }

        return $this->buildData($data);
    }

    public function getSchemasData()
    {
        $data = [];

        /* @var $schema SchemaObject */
        foreach ($this->metaData->getSchemas() as $schema) {
            $data[] = $this->buildData($schema);
        }

        return $data;
    }
}
