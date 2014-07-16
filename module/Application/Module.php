<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $serviceManager      = $e->getApplication()->getServiceManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $this->bootstrapSession($e);
        
        //Add Listeners to watch out for errors
        $eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'));
        $eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER_ERROR, array($this, 'handleError'));
        
        // Log Errors
        $logger = new \Zend\Log\Logger;
        $writer = new \Zend\Log\Writer\Stream('php://output');
        $logger->addWriter($writer);
        \Zend\Log\Logger::registerErrorHandler($logger);
    }
    
    /**
     * Handle Error
     * When an exception occurs this method will email
     * the details over to us.
     * @param MvcEvent $e
     * @todo implement
     */
    public function handleError(MvcEvent $e)
    {
    	
    }
    
    /**
     * Bootstrap Session
     * Session Handling Code
     * @param unknown $e
     */
    public function bootstrapSession($e)
    {
    	$session = $e->getApplication()
    	->getServiceManager()
    	->get('Zend\Session\SessionManager');
    	$session->start();
    
    	$container = new Container('initialized');
    	if (!isset($container->init)) {
    		$session->regenerateId(true);
    		$container->init = 1;
    	}
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
    	return array(
    		'factories' => array(
    			'Zend\Session\SessionManager' => function ($sm) {
    				$config = $sm->get('config');
    				if (isset($config['session'])) {
    					$session = $config['session'];
    
    					$sessionConfig = null;
    					if (isset($session['config'])) {
    						$class = isset($session['config']['class'])  ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
    						$options = isset($session['config']['options']) ? $session['config']['options'] : array();
    						$sessionConfig = new $class();
    						$sessionConfig->setOptions($options);
    					}
    
    					$sessionStorage = null;
    					if (isset($session['storage'])) {
    						$class = $session['storage'];
    						$sessionStorage = new $class();
    					}
    
    					$sessionSaveHandler = null;
    					if (isset($session['save_handler'])) {
    						// class should be fetched from service manager since it will require constructor arguments
    						$sessionSaveHandler = $sm->get($session['save_handler']);
    					}
    
    					$sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);
    
    					if (isset($session['validator'])) {
    						$chain = $sessionManager->getValidatorChain();
    						foreach ($session['validator'] as $validator) {
    							$validator = new $validator();
    							$chain->attach('session.validate', array($validator, 'isValid'));
     						}
    					}
    				} else {
    					$sessionManager = new SessionManager();
    				}
    				Container::setDefaultManager($sessionManager);
    				
    				return $sessionManager;
    			},
    		),
    	);
    }
}
