<?php

namespace PhpDatabaseMySQL\TaskService;

use PhpDatabaseApplication\Authentication\Connection\ConnectionInterface;
use PhpDatabaseSchema\Metadata\Relational\Object\SchemaObject;
use PhpDatabaseSchema\Metadata\Relational\Object\TableObject;
use PhpDatabaseSchema\Metadata\Relational\RelationalMetadataInterface;

class Table
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var RelationalMetadataInterface
     */
    private $metaData;

    public function __construct(ConnectionInterface $connection, RelationalMetadataInterface $metaData)
    {
        $this->connection = $connection;
        $this->metaData = $metaData;
    }

    public function dropTable($tableName, $schemaName)
    {
        return $this->metaData->dropTable($tableName, $schemaName);
    }

    public function truncateTable($tableName, $schemaName)
    {
        return $this->metaData->emptyTable($tableName, $schemaName);
    }

    public function getTableData($tableName, $schemaName)
    {
        /* @var $data TableObject */
        $data = $this->metaData->getTable($tableName, $schemaName);

        if (!$data) {
            return null;
        }

        return $this->buildData($data);
    }

    public function getTablesData($schemaName)
    {
        $data = [];

        /* @var $schema SchemaObject */
        foreach ($this->metaData->getTables($schemaName) as $schema) {
            $data[] = $this->buildData($schema);
        }

        return $data;
    }

    private function buildData(TableObject $table)
    {
        return [
            'name' => $table->getName(),
            'type' => $table->getType(),
            'engine' => $table->getEngine(),
            'collation' => $table->getCollation(),
            'comment' => $table->getComment(),
        ];
    }
}
