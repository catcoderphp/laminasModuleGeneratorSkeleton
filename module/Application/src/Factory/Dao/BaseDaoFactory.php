<?php


namespace Application\Factory\Dao;


use Application\Dao\BaseDao;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

/**
 * Class BaseDaoFactory
 * @package Application\Factory\Dao
 */
class BaseDaoFactory
{
    /**
     * @param ContainerInterface $container
     * @return BaseDao
     */
    public function __invoke(ContainerInterface $container)
    {
        $em = $container->get(EntityManager::class);
        return new BaseDao($em);
    }
}