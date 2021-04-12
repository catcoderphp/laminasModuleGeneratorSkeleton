<?php


namespace Application\Service;


use Application\Dao\ProxyDao;

/**
 * Class ProxyService
 * @package Application\Service
 */
class ProxyService
{
    /**
     * @var ProxyDao
     */
    private $dao;

    /**
     * ProxyService constructor.
     * @param ProxyDao $dao
     */
    public function __construct(ProxyDao $dao)
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