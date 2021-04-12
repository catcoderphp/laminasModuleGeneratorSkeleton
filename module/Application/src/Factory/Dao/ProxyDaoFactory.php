<?php


namespace Application\Factory\Dao;


use Application\Dao\ProxyDao;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

/**
 * Class ProxyDaoFactory
 * @package Application\Factory\Dao
 */
class ProxyDaoFactory
{
    /**
     * @param ContainerInterface $container
     * @return ProxyDao
     */
    public function __invoke(ContainerInterface $container)
    {
        $em = $container->get(EntityManager::class);
        return new ProxyDao($em);
    }
}