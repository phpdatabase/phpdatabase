<?php

namespace PhpDatabaseMongoDB\Controller;

use Exception;
use InvalidArgumentException;
use LogicException;
use PhpDatabaseApplication\Exception\Api\ApiExceptionInterface;
use PhpDatabaseApplication\Exception\Api\MethodNotAllowed;
use PhpDatabaseMongoDB\TaskService\Api as ApiTaskService;
use Zend\Mvc\Controller\AbstractActionController;
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
        $databaseName = $this->params()->fromQuery('database');
        if (!$databaseName) {
            throw new InvalidArgumentException('Missing the "database" query parameter.');
        }

        return new JsonModel([
            'data' => $this->apiTaskService->getBuildInfo($databaseName),
        ]);
    }

    public function commandsAction()
    {
        return new JsonModel([
            'data' => $this->apiTaskService->getCommands(),
        ]);
    }

    public function collectionsAction()
    {
        $databaseName = $this->params()->fromQuery('database');
        if (!$databaseName) {
            throw new InvalidArgumentException('Missing the "database" query parameter.');
        }

        return new JsonModel([
            'data' => $this->apiTaskService->getCollections($databaseName),
        ]);
    }

    public function databasesAction()
    {
        try {
            switch (strtoupper($this->getRequest()->getMethod())) {
                case 'POST':
                    $data = $this->apiTaskService->createDatabase($this->params()->fromPost('name'));
                    break;

                case 'GET':
                    $data = $this->apiTaskService->getDatabases();
                    break;

                default:
                    throw new MethodNotAllowed();
            }
        } catch (Exception $e) {
            if ($e instanceof ApiExceptionInterface) {
                $this->getResponse()->setStatusCode($e->getCode());
            }

            $data = [
                'error' => get_class($e),
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }

        return new JsonModel([
            'data' => $data,
        ]);
    }

    public function serversAction()
    {
        return new JsonModel([
            'data' => $this->apiTaskService->getServers(),
        ]);
    }
}
