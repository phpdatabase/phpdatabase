<?php

namespace PhpDatabaseMySQL\Authentication\Connection;

use PDO;
use PhpDatabaseApplication\Authentication\Connection\ConnectionInterface;
use PhpDatabaseMySQL\Metadata\MySQLMetadata;
use PhpDatabaseSchema\Metadata\MetadataInterface;

class MySQLConnection extends PDO implements ConnectionInterface
{
    private $options;
    private $dsn;
    private $metaData;

    public function __construct(array $options)
    {
        $this->options = $options;
        $this->dsn = sprintf('mysql:host=%s;port=%s;', $this->options['hostname'], $this->options['port']);

        parent::__construct($this->dsn, $this->options['username'], $this->options['password'], []);
    }

    /**
     * Gets the Metadata provider for this connection.
     *
     * @return MetadataInterface
     */
    public function getMetaData()
    {
        if (!$this->metaData) {
            $this->metaData = new MySQLMetadata($this);
        }

        return $this->metaData;
    }

    /**
     * Pings the server to establish a connection.
     */
    public function ping()
    {
        // Nothing to do here.
    }

    public function dropTable($tableName, $schemaName)
    {
        $statement = sprintf("DROP TABLE %s.%s", $tableName, $schemaName);

        return $this->exec($statement);
    }

    public function emptyTable($tableName, $schemaName)
    {
        $statement = sprintf("TRUNCATE TABLE %s.%s", $tableName, $schemaName);

        return $this->exec($statement);
    }
}
