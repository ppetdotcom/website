<?php 
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            'pages' => array(
            	'type' => 'Segment',
            	'options' => array(
            		'route' => '/pages[/:action]',
            		'constraints' => array(
            			'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            		),
            		'defaults' => array(
            			'controller' => 'Application\Controller\Pages',
            			'action'     => 'index',
            		),
            	),
            ),
            'resource' => array(
            	'type' => 'Segment',
            	'options' => array(
            		'route' => '/resource[/:action]',
            		'constraints' => array(
            			'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            		),
            		'defaults' => array(
            			'controller' => 'Application\Controller\Resource',
            			'action'     => 'index',
            		),
            	),
            ),
            'shop' => array(
            	'type' => 'Segment',
            	'options' => array(
            		'route' => '/shop[/:action]',
            		'constraints' => array(
            			'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            		),
            		'defaults' => array(
            			'controller' => 'Application\Controller\Shop',
            			'action'     => 'index',
            		),
            	),
            ),
            'user' => array(
            	'type' => 'Segment',
            	'options' => array(
            		'route' => '/user[/:action]',
            		'constraints' => array(
            			'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            		),
            		'defaults' => array(
            			'controller' => 'Application\Controller\User',
            			'action'     => 'index',
            		),
            	),
            ),
        ),
    ),
    'service_manager' => array(
    	'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            'Zend\Cache\StorageFactory' => function() {
            	return Zend\Cache\StorageFactory::factory(
            		array(
            			'adapter' => array(
            				'name' => 'filesystem',
            				'options' => array(
            					'dirLevel' => 2,
            					'cacheDir' => 'data/cache',
            					'dirPermission' => 0755,
            					'filePermission' => 0666,
            					'namespaceSeparator' => '-db-',
            					'ttl' => 43200,
            				),
            			),
            			'plugins' => array('serializer'),
            		)
            	);
            },
        ),
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'cache' => 'Zend\Cache\StorageFactory',
            'db' => 'Zend\Db\Adapter\Adapter',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Pages' => 'Application\Controller\PagesController',
            'Application\Controller\Resource' => 'Application\Controller\ResourceController',
            'Application\Controller\Shop' => 'Application\Controller\ShopController',
            'Application\Controller\User' => 'Application\Controller\UserController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
