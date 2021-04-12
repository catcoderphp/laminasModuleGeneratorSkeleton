<?php


namespace Application\Factory\Controller;


use Application\Controller\ProxyController;
use Application\Mapper\ProxyMapper;
use Psr\Container\ContainerInterface;

class ProxyControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $mapper = $container->get(ProxyMapper::class);
        return new ProxyController($mapper);
    }
}