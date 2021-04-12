<?php


namespace Application\Service;


use Application\Dao\BaseDao;

/**
 * Class BaseService
 * @package Application\Service
 */
class BaseService
{
    /**
     * @var BaseDao
     */
    private $dao;

    /**
     * BaseService constructor.
     * @param BaseDao $dao
     */
    public function __construct(BaseDao $dao)
    {
        $this->dao = $dao;
    }

    /**
     * @param $id
     * @return array
     */
    public function find($id)
    {
        $item = [];
        $itemObject = $this->dao->find($id);
        if (!is_null($itemObject)) {
            $item = $this->map($itemObject);
        }
        return $item;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $items = [];
        $collection = $this->dao->findAll();
        foreach ($collection as $item) {
            $items [] = $this->map($item);
        }
        return $items;
    }
}