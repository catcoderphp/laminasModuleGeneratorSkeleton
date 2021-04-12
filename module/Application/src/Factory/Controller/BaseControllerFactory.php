<?php


namespace Application\Factory\Controller;


use Application\Controller\BaseController;
use Application\Mapper\BaseMapper;
use Psr\Container\ContainerInterface;

class BaseControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $mapper = $container->get(BaseMapper::class);
        return new BaseController($mapper);
    }
}