<?php

namespace PhpDatabaseMongoDB\Paginator\Adapter;

use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use MongoDB\Collection;
use Zend\Paginator\Adapter\AdapterInterface;

class MongoDB implements AdapterInterface
{
    /**
     * @var Collection
     */
    private $collection;

    public function __construct(Client $client, $databaseName, $collectionName)
    {
        $this->collection  = $client->selectCollection($databaseName, $collectionName);
    }

    public function getItems($offset, $itemCountPerPage)
    {
        $cursor = $this->collection->find([], [
            'skip' => $offset,
            'limit' => $itemCountPerPage,
        ]);

        $items = [];

        foreach ($cursor as $item) {
            $items[] = $this->convertItemToArray($item);
        }

        return $items;
    }

    private function convertItemToArray($item)
    {
        $result = [];

        foreach ($item as $name => $value) {
            if (is_object($value)) {
                $result[$name] = [
                    'type' => str_replace('MongoDB\\BSON\\', '', get_class($value)),
                    'value' => (string)$value,
                ];
            } else {
                $result[$name] = [
                    'type' => $value !== null ? gettype($value) : '',
                    'value' => $value,
                ];
            }
        }

        return $result;
    }

    public function count()
    {
        return $this->collection->count();
    }
}
