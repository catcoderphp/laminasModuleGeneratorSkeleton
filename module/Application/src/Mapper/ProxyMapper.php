<?php


namespace Application\Mapper;


use Application\Interfaces\MapperInterface;
use Application\Service\ProxyService;
use Catcoderphp\CustomConfigProvider\Service\ResponseHandlerService;
use Laminas\Http\Response;

/**
 * Class ProxyMapper
 * @package Application\Mapper
 */
class ProxyMapper extends Mapper implements MapperInterface
{
    /**
     * @var ResponseHandlerService
     */
    private $responseHandler;
    /**
     * @var ProxyService
     */
    private $service;

    private $fields = [];

    /**
     * ProxyMapper constructor.
     * @param ResponseHandlerService $responseHandlerService
     * @param ProxyService $baseService
     */
    public function __construct(ResponseHandlerService $responseHandlerService, ProxyService $baseService)
    {
        $this->responseHandler = $responseHandlerService;
        $this->service = $baseService;
        $this->fields = [];
    }

    /**
     * @param $data
     * @return Response
     */
    public function create($data)
    {
        $error = $this->validator($this->fields, $data);
        if (!$error) {
            $item = $this->service->save($data);
            if (!empty($item)) {
                $this->responseHandler->setData($item);
                $this->responseHandler->setStatusCode(Response::STATUS_CODE_201);
                $this->responseHandler->buildMetaData(
                    false,
                    $this->responseHandler->getStatusCode(),
                    $this->responseHandler->getResponse()->getReasonPhrase(),
                    time(),
                    "Item created!"
                );
            } else {
                $this->responseHandler->setStatusCode(Response::STATUS_CODE_500);
                $this->responseHandler->buildMetaData(
                    true,
                    $this->responseHandler->getStatusCode(),
                    $this->responseHandler->getResponse()->getReasonPhrase(),
                    time(),
                    "Fail on create item"
                );
            }
        } else {
            $this->responseHandler->badRequest("Bad request");
            $this->responseHandler->setData($this->getMessages());
        }
        return $this->responseHandler->toJsonResponse();
    }

    /**
     * @param $id
     * @return Response
     */
    public function get($id)
    {
        $item = $this->service->find($id);
        if (empty($item)) {
            $this->responseHandler->notFound("Item with id: $id has not found");
        } else {
            $this->responseHandler->setStatusCode(Response::STATUS_CODE_200);
            $this->responseHandler->buildMetaData(
                false,
                $this->responseHandler->getStatusCode(),
                $this->responseHandler->getResponse()->getReasonPhrase(),
                time(),
                "Item found!"
            );
            $this->responseHandler->setData($item);
        }
        return $this->responseHandler->toJsonResponse();
    }

    /**
     * @return Response
     */
    public function getList()
    {
        $items = $this->service->findAll();
        if (empty($items)) {
            $this->responseHandler->notFound("Items not found");
        } else {
            $this->responseHandler->setStatusCode(Response::STATUS_CODE_200);
            $this->responseHandler->buildMetaData(
                false,
                $this->responseHandler->getStatusCode(),
                $this->responseHandler->getResponse()->getReasonPhrase(),
                time(),
                "Item found!"
            );
            $this->responseHandler->setData($items);
        }
        return $this->responseHandler->toJsonResponse();
    }

    /**
     * @param $id
     * @param $data
     * @return Response
     */
    public function update($id, $data)
    {
        $error = $this->validator($this->fields, $data);
        if (!$error) {
            $item = $this->service->update($id, $data);
            if (!empty($item)) {
                $this->responseHandler->setData($item);
                $this->responseHandler->setStatusCode(Response::STATUS_CODE_200);
                $this->responseHandler->buildMetaData(
                    false,
                    $this->responseHandler->getStatusCode(),
                    $this->responseHandler->getResponse()->getReasonPhrase(),
                    time(),
                    "Item updated!"
                );
            } else {
                $this->responseHandler->notFound("Item with id: $id has not found");
            }
        } else {
            $this->responseHandler->badRequest("Bad request");
            $this->responseHandler->setData($this->getMessages());
        }
        return $this->responseHandler->toJsonResponse();
    }

    /**
     * @param $id
     * @return Response
     */
    public function delete($id)
    {
        if (!empty($id)) {
            $item = $this->service->delete($id);
            if ($item) {
                $this->responseHandler->setData([
                    "item" => [
                        "id" => "$id",
                        "deleted" => $item
                    ]
                ]);
                $this->responseHandler->setStatusCode(Response::STATUS_CODE_200);
                $this->responseHandler->buildMetaData(
                    false,
                    $this->responseHandler->getStatusCode(),
                    $this->responseHandler->getResponse()->getReasonPhrase(),
                    time(),
                    "Item deleted!"
                );
            } else {
                $this->responseHandler->notFound("Item with id: $id has not found");
            }
        } else {
            $this->responseHandler->badRequest("Bad request");
            $this->responseHandler->setData($this->getMessages());
        }
        return $this->responseHandler->toJsonResponse();
    }

    /**
     * @return Response
     */
    private function notImplemented()
    {
        $this->responseHandler->notImplemented();
        return $this->responseHandler->toJsonResponse();
    }
}