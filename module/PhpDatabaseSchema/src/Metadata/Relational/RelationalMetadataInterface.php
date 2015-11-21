<?php

namespace PhpDatabaseSchema\Metadata\Relational;

use PhpDatabaseSchema\Metadata\MetadataInterface;

interface RelationalMetadataInterface extends MetadataInterface
{
    public function getCharacterSets();

    public function getCollations();

    public function getColumn($columnName, $tableName, $schemaName);

    public function getColumns($tableName, $schemaName);

    public function getConstraint($constraintName, $tableName, $schemaName);

    public function getConstraints($tableName, $schemaName);

    public function getEngines();

    public function getTable($tableName, $schemaName);

    public function getTables($schemaName);

    public function getTrigger($triggerName, $schemaName);

    public function getTriggers($schemaName);

    public function getView($viewName, $schemaName);

    public function getViews($schemaName);
}
