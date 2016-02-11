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
            'mongo' => MongoDBConnection::class,
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
                            'collections' => [
                                'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                                'options' => [
                                    'route' => '/collections',
                                    'defaults' => [
                                        'controller' => 'mongo-api',
                                        'action' => 'collections',
                                    ],
                                ],
                            ],
                            'databases' => [
                                'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                                'options' => [
                                    'route' => '/databases',
                                    'defaults' => [
                                        'controller' => 'mongo-api',
                                        'action' => 'databases',
                                    ],
                                ],
                            ],
                            'servers' => [
                                'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                                'options' => [
                                    'route' => '/servers',
                                    'defaults' => [
                                        'controller' => 'mongo-api',
                                        'action' => 'servers',
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
