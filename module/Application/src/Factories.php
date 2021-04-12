<?php


namespace Application;


use Application\Factory\Controller\BaseControllerFactory;
use Application\Factory\Dao\BaseDaoFactory;
use Application\Factory\Hydrator\HomeHydratorFactory;
use Application\Factory\Mapper\BaseMapperFactory;
use Application\Factory\Service\BaseServiceFactory;
use Application\Factory\Service\ExternalRequestServiceFactory;
use Laminas\Cache\Storage\Adapter\Redis;
use Laminas\ServiceManager\Factory\InvokableFactory;

/**
 * Class Factories
 * @package Application
 */
class Factories
{
    /**
     * @var string[]
     */
    private $service_manager = [        
 //Proxy Configuration
 'Application\Dao\ProxyDao' => 'Application\Factory\Dao\ProxyDaoFactory',
 'Application\Service\ProxyService' => 'Application\Factory\Service\ProxyServiceFactory',
 'Application\Mapper\ProxyMapper' => 'Application\Factory\Mapper\ProxyMapperFactory',
 //Base Configuration
 'Application\Dao\BaseDao' => 'Application\Factory\Dao\BaseDaoFactory',
 'Application\Service\BaseService' => 'Application\Factory\Service\BaseServiceFactory',
 'Application\Mapper\BaseMapper' => 'Application\Factory\Mapper\BaseMapperFactory',
        
    ];
    /**
     * @var string[]
     */
    private $controllers = [  
 'Application\Controller\Proxy' => 'Application\Factory\Controller\ProxyControllerFactory',
        'Application\Controller\Base' => 'Application\Factory\Controller\BaseControllerFactory',
        "Application\\Controller\\Base" => BaseControllerFactory::class
    ];

    /**
     * @return array
     */
    public function getServiceManager(): array
    {
        return $this->service_manager;
    }

    /**
     * @return array
     */
    public function getControllers(): array
    {
        return $this->controllers;
    }
}
