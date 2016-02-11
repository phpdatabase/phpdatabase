<?php

namespace PhpDatabaseMySQL\Metadata;

use PDO;
use PhpDatabaseSchema\Metadata\Relational\Object\CharacterSetObject;
use PhpDatabaseSchema\Metadata\Relational\Object\CollationObject;
use PhpDatabaseSchema\Metadata\Relational\Object\ColumnObject;
use PhpDatabaseSchema\Metadata\Relational\Object\EngineObject;
use PhpDatabaseSchema\Metadata\Relational\Object\SchemaObject;
use PhpDatabaseSchema\Metadata\Relational\Object\TableObject;
use PhpDatabaseSchema\Metadata\Relational\RelationalMetadataInterface;

class MySQLMetadata implements RelationalMetadataInterface
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function dropSchema($schemaName)
    {
        $statement = $this->pdo->prepare(sprintf("DROP DATABASE %s", $schemaName));

        return $statement->execute();
    }

    public function dropTable($tableName, $schemaName)
    {
        $statement = $this->pdo->prepare(sprintf("DROP TABLE %s.%s", $schemaName, $tableName));

        return $statement->execute();
    }

    public function getSchema($schemaName)
    {
        $sql = "
            SELECT
                *
            FROM
                INFORMATION_SCHEMA.SCHEMATA
            WHERE
                SCHEMA_NAME = :schemaName";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue('schemaName', $schemaName);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        $schemaObject = new SchemaObject($data['SCHEMA_NAME']);
        $schemaObject->setDefaultCharacterSetName($data['DEFAULT_CHARACTER_SET_NAME']);
        $schemaObject->setDefaultCollationName($data['DEFAULT_COLLATION_NAME']);

        return $schemaObject;
    }

    public function getSchemas()
    {
        $sql = "
            SELECT
                *
            FROM
                INFORMATION_SCHEMA.SCHEMATA
            WHERE
                SCHEMA_NAME != 'INFORMATION_SCHEMA'
            ORDER BY
                SCHEMA_NAME ASC";

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $result = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $schemaObject = new SchemaObject($data['SCHEMA_NAME']);
            $schemaObject->setDefaultCharacterSetName($data['DEFAULT_CHARACTER_SET_NAME']);
            $schemaObject->setDefaultCollationName($data['DEFAULT_COLLATION_NAME']);

            $result[] = $schemaObject;
        }
        return $result;
    }

    public function getCharacterSets()
    {
        $sql = "SELECT * FROM INFORMATION_SCHEMA.CHARACTER_SETS ORDER BY CHARACTER_SET_NAME ASC";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $result = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $characterSetObject = new CharacterSetObject($data['CHARACTER_SET_NAME']);
            $characterSetObject->setDefaultCollationName($data['DEFAULT_COLLATE_NAME']);
            $characterSetObject->setDescription($data['DESCRIPTION']);
            $characterSetObject->setMaximumLength((int)$data['MAXLEN']);

            $result[] = $characterSetObject;
        }
        return $result;
    }

    public function getCollations()
    {
        $sql = "SELECT * FROM INFORMATION_SCHEMA.COLLATIONS ORDER BY COLLATION_NAME ASC";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $result = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $collationObject = new CollationObject($data['COLLATION_NAME']);
            $collationObject->setCharacterSetName($data['CHARACTER_SET_NAME']);
            $collationObject->setId((int)$data['ID']);
            $collationObject->setIsDefault($data['IS_DEFAULT'] === 'Yes');
            $collationObject->setIsCompiled($data['IS_COMPILED'] === 'Yes');
            $collationObject->setSortLength((int)$data['SORTLEN']);

            $result[] = $collationObject;
        }
        return $result;
    }

    public function getColumn($columnName, $tableName, $schemaName)
    {
    }

    public function getColumns($tableName, $schemaName)
    {
        $sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = :table AND TABLE_SCHEMA = :schema";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':schema', $schemaName, PDO::PARAM_STR);
        $statement->bindValue(':table', $tableName, PDO::PARAM_STR);
        $statement->execute();

        $result = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $columnObject = new ColumnObject($data['COLUMN_NAME']);
            $columnObject->setDataType($data['DATA_TYPE']);
            $columnObject->setNullable($data['IS_NULLABLE'] === 'YES');
            $columnObject->setDefaultValue($data['COLUMN_DEFAULT']);
            $columnObject->setNumberPrecision($data['NUMERIC_PRECISION']);
            $columnObject->setNumberScale($data['NUMERIC_SCALE']);
            $columnObject->setCharacterSetName($data['CHARACTER_SET_NAME']);
            $columnObject->setCollationName($data['COLLATION_NAME']);

            if ($columnObject->getDataType() === 'enum' || $columnObject->getDataType() === 'set') {
                $permittedValues = $this->parsePermittedValues($data['COLUMN_TYPE']);

                $columnObject->setPermittedValues($permittedValues);
            }

            $result[] = $columnObject;
        }
        return $result;
    }

    public function getConstraint($constraintName, $tableName, $schemaName)
    {
    }

    public function getConstraints($tableName, $schemaName)
    {
        return [];
    }

    public function getEngines()
    {
        $sql = "SELECT * FROM INFORMATION_SCHEMA.ENGINES ORDER BY ENGINE ASC";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $result = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $engineObject = new EngineObject($data['ENGINE']);
            $engineObject->setSupport($data['SUPPORT']);
            $engineObject->setComment($data['COMMENT']);
            $engineObject->setTransactions($data['TRANSACTIONS']);
            $engineObject->setXa($data['XA']);
            $engineObject->setSavepoints($data['SAVEPOINTS']);

            $result[] = $engineObject;
        }
        return $result;
    }

    public function getTable($tableName, $schemaName)
    {
        $sql = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = :table AND TABLE_SCHEMA = :schema";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':schema', $schemaName, PDO::PARAM_STR);
        $statement->bindValue(':table', $tableName, PDO::PARAM_STR);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        $tableObject = new TableObject($data['TABLE_NAME']);
        $tableObject->setType($data['TABLE_TYPE']);
        $tableObject->setEngine($data['ENGINE']);
        $tableObject->setCollation($data['TABLE_COLLATION']);
        $tableObject->setComment($data['TABLE_COMMENT']);

        return $tableObject;
    }

    public function getTables($schemaName)
    {
        $sql = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = :schema ORDER BY TABLE_NAME ASC";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':schema', $schemaName, PDO::PARAM_STR);
        $statement->execute();

        $result = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $data) {
            $tableObject = new TableObject($data['TABLE_NAME']);
            $tableObject->setType($data['TABLE_TYPE']);
            $tableObject->setEngine($data['ENGINE']);
            $tableObject->setCollation($data['TABLE_COLLATION']);
            $tableObject->setComment($data['TABLE_COMMENT']);

            $result[] = $tableObject;
        }
        return $result;
    }

    public function getTrigger($triggerName, $schemaName)
    {
    }

    public function getTriggers($schemaName)
    {
        return [];
    }

    public function getView($viewName, $schemaName)
    {
    }

    public function getViews($schemaName)
    {
        return [];
    }

    public function truncateTable($tableName, $schemaName)
    {
        $statement = $this->pdo->prepare(sprintf("TRUNCATE TABLE %s.%s", $schemaName, $tableName));

        return $statement->execute();
    }

    private function parsePermittedValues($input)
    {
        $permittedValues = null;

        // Taken from zendframework/zend-db. Thanks!
        if (preg_match('/^(?:enum|set)\((.+)\)$/i', $input, $matches)) {
            $permittedValues = $matches[1];

            $regex = "/\\s*'((?:[^']++|'')*+)'\\s*(?:,|\$)/";
            if (preg_match_all($regex, $permittedValues, $matches, PREG_PATTERN_ORDER)) {
                $permittedValues = str_replace("''", "'", $matches[1]);
            } else {
                $permittedValues = [$permittedValues];
            }
        }

        return $permittedValues;
    }
}
