<?php

namespace PhpDatabaseMySQL;

use PhpDatabaseMySQL\Authentication\Connection\MySQLConnection;
use PhpDatabaseMySQL\Controller\Service\SchemaFactory;
use PhpDatabaseMySQL\Controller\Service\TableFactory;
use PhpDatabaseMySQL\TaskService\Service\SchemaFactory as SchemaFactoryTaskService;
use PhpDatabaseMySQL\TaskService\Service\TableFactory as TableFactoryTaskService;

return [
    'controllers' => [
        'factories' => [
            'mysql-schema' => SchemaFactory::class,
            'mysql-table' => TableFactory::class,
        ],
    ],
    'phpdatabase_connection_manager' => [
        'invokables' => [
            'mysql' => MySQLConnection::class,
        ],
    ],
    'router' => [
        'routes' => [
            'mysql' => [
                'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                'options' => [
                    'route' => '/mysql',
                ],
                'child_routes' => [
                    'schema' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
                        'options' => [
                            'route' => '/schema/:schema',
                            'defaults' => [
                                'controller' => 'mysql-schema',
                                'action' => 'schema',
                            ],
                        ],
                    ],
                    'schemas' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                        'options' => [
                            'route' => '/schemas',
                            'defaults' => [
                                'controller' => 'mysql-schema',
                                'action' => 'schemas',
                            ],
                        ],
                    ],
                    'table' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
                        'options' => [
                            'route' => '/table/:schema/:table',
                            'defaults' => [
                                'controller' => 'mysql-table',
                                'action' => 'table',
                            ],
                        ],
                    ],
                    'table-drop' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
                        'options' => [
                            'route' => '/table-drop/:schema/:table',
                            'defaults' => [
                                'controller' => 'mysql-table',
                                'action' => 'drop',
                            ],
                        ],
                    ],
                    'table-empty' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
                        'options' => [
                            'route' => '/table-empty/:schema/:table',
                            'defaults' => [
                                'controller' => 'mysql-table',
                                'action' => 'empty',
                            ],
                        ],
                    ],
                    'tables' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
                        'options' => [
                            'route' => '/tables/:schema',
                            'defaults' => [
                                'controller' => 'mysql-table',
                                'action' => 'tables',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'mysql.taskservice.schema' => SchemaFactoryTaskService::class,
            'mysql.taskservice.table' => TableFactoryTaskService::class,
        ],
    ],
];