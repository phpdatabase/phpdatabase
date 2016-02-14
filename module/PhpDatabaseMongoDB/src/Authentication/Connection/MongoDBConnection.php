<?php

namespace PhpDatabaseMongoDB\Authentication\Connection;

use MongoDB\Client;
use MongoDB\Driver\Command;
use PhpDatabaseApplication\Authentication\Connection\ConnectionInterface;
use PhpDatabaseMongoDB\Metadata\MongoDBMetadata;
use PhpDatabaseSchema\Metadata\MetadataInterface;

class MongoDBConnection implements ConnectionInterface
{
    private $client;
    private $metaData;

    public function __construct(array $options)
    {
        $dsn = $this->buildDsn($options);

        $this->client = new Client($dsn);
    }

    private function buildDsn(array $options)
    {
        $dsn = 'mongodb://';

        if ($options['username'] && $options['password']) {
            $dsn .= sprintf('%s:%s@', $options['username'], $options['password']);
        }

        return $dsn . sprintf('%s:%d', $options['hostname'], $options['port']);
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

    public function getClient()
    {
        return $this->client;
    }

    /**
     * Pings the server to establish a connection.
     */
    public function ping()
    {
        $command = new Command(['ping' => 1]);

        $this->client->
        $this->client->executeCommand('admin', $command);
    }
}
