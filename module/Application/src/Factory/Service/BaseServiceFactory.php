<?php


namespace Application\Factory\Service;


use Application\Dao\BaseDao;
use Application\Service\BaseService;
use Psr\Container\ContainerInterface;

/**
 * Class BaseServiceFactory
 * @package Application\Factory\Service
 */
class BaseServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return BaseService
     */
    public function __invoke(ContainerInterface $container): BaseService
    {
        $dao = $container->get(BaseDao::class);
        return new BaseService($dao);
    }
}