<?php


namespace Application\Factory\Service;


use Application\Dao\ProxyDao;
use Application\Service\ProxyService;
use Psr\Container\ContainerInterface;

/**
 * Class ProxyServiceFactory
 * @package Application\Factory\Service
 */
class ProxyServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return ProxyService
     */
    public function __invoke(ContainerInterface $container): ProxyService
    {
        $dao = $container->get(ProxyDao::class);
        return new ProxyService($dao);
    }
}