<?php

namespace PhpDatabaseMongoDB;

use PhpDatabaseMongoDB\Authentication\Connection\MongoDBConnection;
use PhpDatabaseMongoDB\Controller\Service\ApiFactory;
use PhpDatabaseMongoDB\TaskService\Service\ApiFactory as ApiFactoryTaskService;

return [
    'controllers' => [
        'factories' => [
            'mongo-api' => ApiFactory::class,
        ],
    ],
    'phpdatabase_connection_manager' => [
        'invokables' => [
            'mongodb' => MongoDBConnection::class,
        ],
    ],
    'router' => [
        'routes' => [
            'api' => [
                'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                'options' => [
                    'route' => '/api',
                    'defaults' => [
                        'controller' => 'application-index',
                        'action' => 'index',
                    ],
                ],
                'child_routes' => [
                    'mongodb' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                        'options' => [
                            'route' => '/mongodb',
                            'defaults' => [
                                'controller' => 'application-index',
                                'action' => 'index',
                            ],
                        ],
                        'child_routes' => [
                            'build-info' => [
                                'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                                'options' => [
                                    'route' => '/build-info',
                                    'defaults' => [
                                        'controller' => 'mongo-api',
                                        'action' => 'buildInfo',
                                    ],
                                ],
                            ],
                            'commands' => [
                                'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                                'options' => [
                                    'route' => '/commands',
                                    'defaults' => [
                                        'controller' => 'mongo-api',
                                        'action' => 'commands',
                                    ],
                                ],
                            ],
                            'collection' => [
                                'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                                'options' => [
                                    'route' => '/collection',
                                    'defaults' => [
                                        'controller' => 'mongo-api',
                                        'action' => 'collection',
                                    ],
                                ],
                            ],
                            'database' => [
                                'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                                'options' => [
                                    'route' => '/database',
                                    'defaults' => [
                                        'controller' => 'mongo-api',
                                        'action' => 'database',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'mongodb.taskservice.api' => ApiFactoryTaskService::class,
        ],
    ],
];
