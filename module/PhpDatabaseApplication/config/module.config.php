<?php

namespace PhpDatabaseApplication;

use PhpDatabaseApplication\Authentication\Service\AuthenticationServiceFactory;
use PhpDatabaseApplication\Controller\Service\AuthenticationFactory;
use PhpDatabaseApplication\Controller\Service\IndexFactory;
use PhpDatabaseApplication\Form\Service\AuthenticateFactory as AuthenticateFormFactory;
use PhpDatabaseApplication\InputFilter\Authenticate;
use PhpDatabaseApplication\Validator\Service\AuthenticationFactory as AuthenticationValidatorFactory;

return [
    'controllers' => [
        'factories' => [
            'application-authentication' => AuthenticationFactory::class,
            'application-index' => IndexFactory::class,
        ],
    ],
    'forms' => [
        'application.form.authenticate' => [
            'type' => 'application.form.authenticate',
            'input_filter' => 'application.inputfilter.authenticate',
        ],
    ],
    'form_elements' => [
        'factories' => [
            'application.form.authenticate' => AuthenticateFormFactory::class,
        ],
    ],
    'input_filters' => [
        'invokables' => [
            'application.inputfilter.authenticate' => Authenticate::class,
        ],
    ],
    'router' => [
        'routes' => [
            'dashboard' => [
                'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => 'application-index',
                        'action' => 'index',
                    ],
                ],
            ],
            'login' => [
                'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => 'application-authentication',
                        'action' => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => 'application-authentication',
                        'action' => 'logout',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\\Session\\Service\\ContainerAbstractServiceFactory',
        ],
        'aliases' => [
            'Zend\\Authentication\\AuthenticationService' => 'application.authentication.service',
        ],
        'factories' => [
            'application.authentication.service' => AuthenticationServiceFactory::class,
            'Zend\\Session\\Config\\ConfigInterface' => 'Zend\\Session\\Service\\SessionConfigFactory',
            'Zend\\Session\\ManagerInterface' => 'Zend\\Session\\Service\\SessionManagerFactory',
            'Zend\\Session\\Storage\\StorageInterface' => 'Zend\Session\Service\\StorageFactory',
        ],
    ],
    'session_containers' => [
        'authentication',
    ],
    'session_config' => [
        'name' => 'phpdatabase',
        'rememberMeSeconds' => 3600,
    ],
    'session_manager' => [
        'validators' => [
            'Zend\Session\Validator\RemoteAddr',
            'Zend\Session\Validator\HttpUserAgent',
        ],
    ],
    'session_storage' => [
        'type' => 'Zend\\Session\\Storage\\SessionArrayStorage',
        'options' => [],
    ],
    'translator' => [
        'locale' => 'en_GB',
        'translation_file_patterns' => [
            [
                'type' => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php',
            ],
        ],
    ],
    'validators' => [
        'factories' => [
            'PhpDatabaseApplication\\Validator\\Authentication' => AuthenticationValidatorFactory::class,
        ],
    ],
    'view_manager' => [
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
