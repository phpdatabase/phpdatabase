<?php

namespace PhpDatabaseApplication\Authentication\Connection;

use PhpDatabaseSchema\Metadata\MetadataInterface;

interface ConnectionInterface
{
    /**
     * Gets the Metadata provider for this connection.
     *
     * @return MetadataInterface
     */
    public function getMetaData();

    /**
     * Pings the server to establish a connection.
     */
    public function ping();
}
