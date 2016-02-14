<?php

namespace PhpDatabaseMongoDB\Controller;

use Exception;
use PhpDatabaseApplication\Exception\Api\ApiExceptionInterface;
use PhpDatabaseApplication\Exception\Api\MethodNotAllowed;
use PhpDatabaseMongoDB\TaskService\Api as ApiTaskService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\JsonModel;

class Api extends AbstractActionController
{
    /**
     * The service that is able to get information about the connection.
     *
     * @var ApiTaskService
     */
    private $apiTaskService;

    public function __construct(ApiTaskService $apiTaskService)
    {
        $this->apiTaskService = $apiTaskService;
    }

    public function buildInfoAction()
    {
        return new JsonModel([
            'data' => $this->apiTaskService->getBuildInfo(),
        ]);
    }

    public function commandsAction()
    {
        return new JsonModel([
            'data' => $this->apiTaskService->getCommands(),
        ]);
    }

    public function collectionAction()
    {
        $paginator = null;

        try {
            switch (strtoupper($this->getRequest()->getMethod())) {
                case 'DELETE':
                    $json = json_decode($this->getRequest()->getContent(), true);
                    $data = $this->apiTaskService->dropCollection($json['databaseName'], $json['collectionName']);
                    break;

                case 'GET':
                    $databaseName = $this->params()->fromQuery('databaseName');
                    $collectionName = $this->params()->fromQuery('collectionName');

                    if ($collectionName) {
                        $paginator = $this->apiTaskService->getCollection($databaseName, $collectionName);
                        $data = $this->convertPaginatorToArray($paginator);
                    } else {
                        $data = $this->apiTaskService->getCollections($databaseName);
                    }
                    break;

                case 'POST':
                    $json = json_decode($this->getRequest()->getContent(), true);
                    $data = $this->apiTaskService->createCollection($json['databaseName'], $json['collectionName']);
                    break;

                default:
                    throw new MethodNotAllowed();
            }
        } catch (Exception $e) {
            $data = $this->handleException($e);
        }

        $result = [
            'data' => $data,
        ];

        if ($paginator) {
            $result = [
                'total' => $paginator->getTotalItemCount(),
            ] + $result;
        }

        return new JsonModel($result);
    }

    public function databaseAction()
    {
        try {
            switch (strtoupper($this->getRequest()->getMethod())) {
                case 'DELETE':
                    $json = json_decode($this->getRequest()->getContent(), true);
                    $data = $this->apiTaskService->dropDatabase($json['databaseName']);
                    break;

                case 'GET':
                    $data = $this->apiTaskService->getDatabases();
                    break;

                case 'POST':
                    $json = json_decode($this->getRequest()->getContent(), true);
                    $data = $this->apiTaskService->createDatabase($json['databaseName']);
                    break;

                default:
                    throw new MethodNotAllowed();
            }
        } catch (Exception $e) {
            $data = $this->handleException($e);
        }

        return new JsonModel([
            'data' => $data,
        ]);
    }

    private function convertPaginatorToArray(Paginator $paginator)
    {
        $paginator->setItemCountPerPage(max(1, (int)$this->params()->fromQuery('limit', 25)));
        $paginator->setCurrentPageNumber(max(1, (int)$this->params()->fromQuery('page', 1)));

        $data = [];

        foreach ($paginator as $item) {
            $data[] = $item;
        }

        return $data;
    }

    private function handleException(Exception $e)
    {
        if ($e instanceof ApiExceptionInterface) {
            $this->getResponse()->setStatusCode($e->getCode());
        }

        return [
            'error' => get_class($e),
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        ];
    }
}
