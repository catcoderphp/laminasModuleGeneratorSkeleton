<?php


namespace Application\Factory\Mapper;


use Application\Mapper\BaseMapper;
use Application\Service\BaseService;
use Catcoderphp\CustomConfigProvider\Service\ResponseHandlerService;
use Psr\Container\ContainerInterface;

/**
 * Class BaseMapperFactory
 * @package Application\Factory\Mapper
 */
class BaseMapperFactory
{
    /**
     * @param ContainerInterface $container
     * @return BaseMapper
     */
    public function __invoke(ContainerInterface $container): BaseMapper
    {
        $responseHandlerService = $container->get(ResponseHandlerService::class);
        $service = $container->get(BaseService::class);
        return new BaseMapper($responseHandlerService, $service);
    }
}