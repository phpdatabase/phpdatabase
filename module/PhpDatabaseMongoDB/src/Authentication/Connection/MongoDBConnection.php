<?php

namespace PhpDatabaseMongoDB\Authentication\Connection;

use MongoDB\Driver\Command;
use MongoDB\Driver\Manager;
use PhpDatabaseApplication\Authentication\Connection\ConnectionInterface;
use PhpDatabaseMongoDB\Metadata\MongoDBMetadata;
use PhpDatabaseSchema\Metadata\MetadataInterface;

class MongoDBConnection implements ConnectionInterface
{
    private $options;
    private $dsn;
    private $manager;
    private $metaData;

    public function __construct(array $options)
    {
        $this->options = $options;

        $this->dsn = 'mongodb://';
        if ($this->options['username'] && $this->options['password']) {
            $this->dsn .= sprintf('%s:%s@', $this->options['username'], $this->options['password']);
        }
        $this->dsn .= sprintf('%s:%d', $this->options['hostname'], $this->options['port']);

        $this->manager = new Manager($this->dsn);
    }

    /**
     * Gets the Metadata provider for this connection.
     *
     * @return MetadataInterface
     */
    public function getMetaData()
    {
        if (!$this->metaData) {
            $this->metaData = new MongoDBMetadata($this);
        }

        return $this->metaData;
    }

    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Pings the server to establish a connection.
     */
    public function ping()
    {
        $command = new Command(['ping' => 1]);

        $this->manager->executeCommand('admin', $command);
    }
}
