<?php

namespace PhpDatabaseMySQL\Controller;

use PhpDatabaseMySQL\TaskService\Info as InfoTaskService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class Info extends AbstractActionController
{
    /**
     * The service that is able to get information about the server.
     *
     * @var InfoTaskService
     */
    private $infoTaskService;

    public function __construct(InfoTaskService $infoTaskService)
    {
        $this->infoTaskService = $infoTaskService;
    }

    public function characterSetsAction()
    {
        return new JsonModel([
            'data' => $this->infoTaskService->getCharacterSetsData(),
        ]);
    }

    public function collationsAction()
    {
        return new JsonModel([
            'data' => $this->infoTaskService->getCollationData(),
        ]);
    }

    public function enginesAction()
    {
        return new JsonModel([
            'data' => $this->infoTaskService->getEngineData(),
        ]);
    }
}
