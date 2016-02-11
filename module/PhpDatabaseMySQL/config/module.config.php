<?php

namespace PhpDatabaseMySQL;

use PhpDatabaseMySQL\Authentication\Connection\MySQLConnection;
use PhpDatabaseMySQL\Controller\Service\InfoFactory;
use PhpDatabaseMySQL\Controller\Service\SchemaFactory;
use PhpDatabaseMySQL\Controller\Service\TableFactory;
use PhpDatabaseMySQL\TaskService\Service\InfoFactory as InfoFactoryTaskService;
use PhpDatabaseMySQL\TaskService\Service\SchemaFactory as SchemaFactoryTaskService;
use PhpDatabaseMySQL\TaskService\Service\TableFactory as TableFactoryTaskService;

return [
    'controllers' => [
        'factories' => [
            'mysql-info' => InfoFactory::class,
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
                    'character-sets' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                        'options' => [
                            'route' => '/character-sets',
                            'defaults' => [
                                'controller' => 'mysql-info',
                                'action' => 'character-sets',
                            ],
                        ],
                    ],
                    'collations' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                        'options' => [
                            'route' => '/collations',
                            'defaults' => [
                                'controller' => 'mysql-info',
                                'action' => 'collations',
                            ],
                        ],
                    ],
                    'drop-schema' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
                        'options' => [
                            'route' => '/drop-schema/:schema',
                            'defaults' => [
                                'controller' => 'mysql-schema',
                                'action' => 'drop',
                            ],
                        ],
                    ],
                    'drop-table' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
                        'options' => [
                            'route' => '/drop-table/:schema/:table',
                            'defaults' => [
                                'controller' => 'mysql-table',
                                'action' => 'drop',
                            ],
                        ],
                    ],
                    'engines' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                        'options' => [
                            'route' => '/engines',
                            'defaults' => [
                                'controller' => 'mysql-info',
                                'action' => 'engines',
                            ],
                        ],
                    ],
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
                    'truncate-table' => [
                        'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
                        'options' => [
                            'route' => '/truncate-table/:schema/:table',
                            'defaults' => [
                                'controller' => 'mysql-table',
                                'action' => 'empty',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'mysql.taskservice.info' => InfoFactoryTaskService::class,
            'mysql.taskservice.schema' => SchemaFactoryTaskService::class,
            'mysql.taskservice.table' => TableFactoryTaskService::class,
        ],
    ],
];
