<?php


namespace Application\Dao;


use Application\Entity\BaseEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\RepositoryFactory;

class BaseDao
{
    /**
     * @var RepositoryFactory
     */
    private $repo;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->repo = $this->em->getRepository(BaseEntity::class);
    }

    public function findAll()
    {
        return $this->repo->findAll();
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

}