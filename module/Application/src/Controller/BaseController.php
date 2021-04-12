<?php


namespace Application\Controller;


use Application\Mapper\BaseMapper;
use Laminas\Mvc\Controller\AbstractRestfulController;

class BaseController extends AbstractRestfulController
{
    /**
     * @var BaseMapper
     */
    private $mapper;

    public function __construct(BaseMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function get($id)
    {
        return $this->mapper->get($id);
    }

    public function getList()
    {
        return $this->mapper->getList();
    }

    public function create($data)
    {
        return $this->mapper->create($data);
    }

    public function update($id, $data)
    {
        return $this->mapper->update($id, $data);
    }

    public function delete($id)
    {
        return $this->mapper->delete($id);
    }
}