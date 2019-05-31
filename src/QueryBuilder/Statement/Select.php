<?php

namespace Maarsson\QueryBuilder\Statement;

use Maarsson\QueryBuilder\Connection;
use Maarsson\QueryBuilder\Grammar\GroupBy;
use Maarsson\QueryBuilder\Grammar\Limit;
use Maarsson\QueryBuilder\Grammar\Offset;
use Maarsson\QueryBuilder\Grammar\OrderBy;
use Maarsson\QueryBuilder\Grammar\Select as Grammar;
use Maarsson\QueryBuilder\Grammar\Where;

class Select
{
    use Grammar, GroupBy, Limit, Offset, OrderBy, Where;

    protected $connection;
    protected $statement;
    protected $query;

    public $column = ['*'];
    public $groupBy = [];
    public $limit;
    public $offset;
    public $orderBy = [];
    public $where = [];

    public function __construct()
    {
        $this->connection = Connection::init();

        return $this;
    }

    public function query($statement)
    {
        $this->statement = $statement;

        $this->query = $this->connection->prepare(
            $this->buildQueryString()
        );
        $this->bindParams();

        $this->query->execute();

        return $this;
    }

    public function fetchAll()
    {
        return $this->query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function buildQueryString()
    {
        $this->grammar = [];
        $this->grammar[] = $this->addStatement();
        $this->grammar[] = $this->addWheres();
        $this->grammar[] = $this->addGroupBy();
        $this->grammar[] = $this->addOrderBy();
        $this->grammar[] = $this->addLimit();
        $this->grammar[] = $this->addOffset();

        return implode(' ', array_filter($this->grammar));
    }

    public function bindParams()
    {
        foreach ($this->where as $key => $where) {
            $this->query->bindParam($key +1 , $where[2]);
        }
    }
}
