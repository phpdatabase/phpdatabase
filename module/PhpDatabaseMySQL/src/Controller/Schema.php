<?php

namespace PhpDatabaseMySQL\Controller;

use PhpDatabaseMySQL\TaskService\Schema as SchemaTaskService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class Schema extends AbstractActionController
{
    /**
     * The service that contains logic to manage the schema's.
     *
     * @var SchemaTaskService
     */
    private $schemaTaskService;

    public function __construct(SchemaTaskService $schemaTaskService)
    {
        $this->schemaTaskService = $schemaTaskService;
    }

    public function dropAction()
    {
        $schemaName = $this->params('schema');
        $data = $this->schemaTaskService->dropSchema($schemaName);

        return new JsonModel([
            'data' => $data,
        ]);
    }

    public function schemaAction()
    {
        $schemaName = $this->params('schema');

        $data = $this->schemaTaskService->getSchemaData($schemaName);
        if (!$data) {
            return $this->notFoundAction();
        }

        return new JsonModel([
            'data' => $data,
        ]);
    }

    public function schemasAction()
    {
        return new JsonModel([
            'data' => $this->schemaTaskService->getSchemasData(),
        ]);
    }
}
