<?php


namespace Application\Factory\Mapper;


use Application\Mapper\ProxyMapper;
use Application\Service\ProxyService;
use Catcoderphp\CustomConfigProvider\Service\ResponseHandlerService;
use Psr\Container\ContainerInterface;

/**
 * Class ProxyMapperFactory
 * @package Application\Factory\Mapper
 */
class ProxyMapperFactory
{
    /**
     * @param ContainerInterface $container
     * @return ProxyMapper
     */
    public function __invoke(ContainerInterface $container): ProxyMapper
    {
        $responseHandlerService = $container->get(ResponseHandlerService::class);
        $service = $container->get(ProxyService::class);
        return new ProxyMapper($responseHandlerService, $service);
    }
}