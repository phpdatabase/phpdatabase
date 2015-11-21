<?php

namespace PhpDatabaseMySQL\TaskService;

use PhpDatabaseMySQL\Authentication\Connection\MySQLConnection;
use PhpDatabaseMySQL\Metadata\MySQLMetadata;
use PhpDatabaseSchema\Metadata\Relational\Object\SchemaObject;
use PhpDatabaseSchema\Metadata\Relational\Object\TableObject;

class Table
{
    /**
     * @var MySQLConnection
     */
    private $connection;

    /**
     * @var MySQLMetadata
     */
    private $metaData;

    public function __construct(MySQLConnection $connection)
    {
        $this->connection = $connection;
        $this->metaData = $connection->getMetaData();
    }

    public function dropTable($tableName, $schemaName)
    {
        return $this->connection->dropTable($tableName, $schemaName);
    }

    public function emptyTable($tableName, $schemaName)
    {
        return $this->connection->emptyTable($tableName, $schemaName);
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
