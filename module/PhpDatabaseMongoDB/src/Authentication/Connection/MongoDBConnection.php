<?php

namespace PhpDatabaseMongoDB\Authentication\Connection;

use MongoClient;
use PhpDatabaseApplication\Authentication\Connection\ConnectionInterface;
use PhpDatabaseMongoDB\Metadata\MongoDBMetadata;
use PhpDatabaseSchema\Metadata\MetadataInterface;

class MongoDBConnection extends MongoClient implements ConnectionInterface
{
    private $options;
    private $dsn;
    private $metaData;

    public function __construct(array $options)
    {
        $this->options = $options;

        $this->dsn = 'mongodb://';
        if ($this->options['username'] && $this->options['password']) {
            $this->dsn .= sprintf('%s:%s@', $this->options['username'], $this->options['password']);
        }
        $this->dsn .= sprintf('%s:%d', $this->options['hostname'], $this->options['port']);

        parent::__construct($this->dsn, []);
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

    /**
     * Pings the server to establish a connection.
     */
    public function ping()
    {
        // Nothing to do here.
    }
}
