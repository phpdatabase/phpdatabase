<?php

namespace PhpDatabaseMongoDB;

use PhpDatabaseMongoDB\Authentication\Connection\MongoDBConnection;

return [
    'phpdatabase_connection_manager' => [
        'invokables' => [
            'mongo' => MongoDBConnection::class,
        ],
    ],
];
