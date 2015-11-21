<?php

namespace PhpDatabaseMySQL\TaskService;

use PhpDatabaseMySQL\Metadata\MySQLMetadata;

class Info
{
    private $metaData;

    public function __construct(MySQLMetadata $metaData)
    {
        $this->metaData = $metaData;
    }

    public function getCharacterSetsData()
    {
        $data = [];
        foreach ($this->metaData->getCharacterSets() as $characterSet) {
            $data[] = [
                'name' => $characterSet->getName(),
                'description' => $characterSet->getDescription(),
                'defaultCollationName' => $characterSet->getDefaultCollationName(),
                'maximumLength' => $characterSet->getMaximumLength(),
            ];
        }
        return $data;
    }

    public function getCollationData()
    {
        $data = [];
        foreach ($this->metaData->getCollations() as $collation) {
            $data[] = [
                'name' => $collation->getName(),
                'characterSetName' => $collation->getCharacterSetName(),
                'id' => $collation->getId(),
                'isDefault' => $collation->getIsDefault(),
                'isCompiled' => $collation->getIsCompiled(),
                'sortLength' => $collation->getSortLength(),
            ];
        }
        return $data;
    }

    public function getEngineData()
    {
        $data = [];
        foreach ($this->metaData->getEngines() as $engine) {
            $data[] = [
                'name' => $engine->getName(),
                'support' => $engine->getSupport(),
                'comment' => $engine->getComment(),
                'transactions' => $engine->getTransactions(),
                'xa' => $engine->getXa(),
                'savepoints' => $engine->getSavepoints(),
            ];
        }
        return $data;
    }
}
