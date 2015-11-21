<?php

use PhpDatabaseApplication\Authentication\Service\ConnectionPluginManager;

return array(
    'modules' => array(
        'ZF\DevelopmentMode',

        // Always add vendor directories above this line!
        // Keep our own modules organized from A to Z!
        'PhpDatabaseApplication',
        'PhpDatabaseMongoDB',
        'PhpDatabaseMySQL',
        'PhpDatabasePostgreSQL',
        'PhpDatabaseSchema',
        'PhpDatabaseSQLite',
    ),
    'module_listener_options' => array(
        'cache_dir' => 'data/cache',
        'config_cache_enabled' => true,
        'config_cache_key' => 'app_config',
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_map_cache_enabled' => true,
        'module_map_cache_key' => 'module_map',
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
    'service_listener_options' => array(
        array(
            'service_manager' => 'application.authentication.connectionpluginmanager',
            'config_key' => 'phpdatabase_connection_manager',
            'interface' => 'PhpDatabaseApplication\\Authentication\\Connection\\ConnectionInterface',
            'method' => 'getPhpDatabaseConnectionManager',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'LazyServiceFactory' => 'Zend\ServiceManager\Proxy\LazyServiceFactoryFactory',
        ),
        'invokables' => array(
            'application.authentication.connectionpluginmanager' => ConnectionPluginManager::class,
        ),
    ),
);
