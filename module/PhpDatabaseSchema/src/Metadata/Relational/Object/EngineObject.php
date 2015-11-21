<?php

namespace PhpDatabaseSchema\Metadata\Relational\Object;

class EngineObject
{
    private $name;
    private $support;
    private $comment;
    private $transactions;
    private $xa;
    private $savepoints;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSupport()
    {
        return $this->support;
    }

    public function setSupport($support)
    {
        $this->support = $support;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getTransactions()
    {
        return $this->transactions;
    }

    public function setTransactions($transactions)
    {
        $this->transactions = $transactions;
    }

    public function getXa()
    {
        return $this->xa;
    }

    public function setXa($xa)
    {
        $this->xa = $xa;
    }

    public function getSavepoints()
    {
        return $this->savepoints;
    }

    public function setSavepoints($savepoints)
    {
        $this->savepoints = $savepoints;
    }
}