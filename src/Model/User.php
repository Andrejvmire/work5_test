<?php

namespace App\Model;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class User
{
    private QueryBuilder $_qb;

    private string $_table = 'user';

    public function __construct(Connection $connection)
    {
        $this->_qb = $connection->createQueryBuilder();
    }

    public function insertValue(array $values): QueryBuilder
    {
        $qb = $this->_qb
            ->insert($this->_table);
        foreach ($values as $key => $value) {
            $qb->setValue($key, ":$key")
                ->setParameter($key, $value);
        }
        return $qb;
    }

    /**
     * @param array $values
     * @param array|null ...$where The query restrictions
     * @return QueryBuilder
     */
    public function updateValue(array $values, ?array ...$where): QueryBuilder
    {
        $qb = $this->_qb
            ->update($this->_table);
        foreach ($values as $key => $value) {
            $qb->set($key, ":$key")
                ->setParameter($key, $value);
        }
        foreach ($where as $value) {
            [$op, $key, $val] = $value;
            $qb->andWhere("$key $op :$val")
                ->setParameter($val, $val);
        }
        return $qb;
    }

    /**
     * @param array $fields
     * @param string|null ...$where The query restrictions
     * @return QueryBuilder
     */
    public function select(array $fields, ?string ...$where): QueryBuilder
    {
        $qb = $this->_qb
            ->select(...$fields)
            ->from($this->_table);
        foreach ($where as $value) {
            $qb->andWhere($value);
        }
        return $qb;
    }

    public function findBy($key, $value): QueryBuilder
    {
        return $this->_qb
            ->from($this->_table)
            ->andWhere("$key = '$value'");
    }
}