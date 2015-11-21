<?php

namespace PhpDatabaseMySQL\Controller;

use PhpDatabaseMySQL\TaskService\Table as TableTaskService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class Table extends AbstractActionController
{
    /**
     * The service that contains logic to manage the tables.
     *
     * @var TableTaskService
     */
    private $tableTaskService;

    public function __construct(TableTaskService $tableTaskService)
    {
        $this->tableTaskService = $tableTaskService;
    }

    public function dropAction()
    {
        $tableName = $this->params('table');
        $schemaName = $this->params('schema');

        $data = $this->tableTaskService->dropTable($tableName, $schemaName);

        return new JsonModel([
            'data' => $data,
        ]);
    }

    public function emptyAction()
    {
        $tableName = $this->params('table');
        $schemaName = $this->params('schema');

        $data = $this->tableTaskService->emptyTable($tableName, $schemaName);

        return new JsonModel([
            'data' => $data,
        ]);
    }

    public function tableAction()
    {
        $tableName = $this->params('table');
        $schemaName = $this->params('schema');

        $data = $this->tableTaskService->getTableData($tableName, $schemaName);
        if (!$data) {
            return $this->notFoundAction();
        }

        return new JsonModel([
            'data' => $data,
        ]);
    }

    public function tablesAction()
    {
        $schemaName = $this->params('schema');

        return new JsonModel([
            'data' => $this->tableTaskService->getTablesData($schemaName),
        ]);
    }
}
