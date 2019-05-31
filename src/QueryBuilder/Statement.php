<?php

namespace Maarsson\QueryBuilder;

use Maarsson\QueryBuilder\Schema\Table;
use Maarsson\QueryBuilder\Statement\Select;
use Maarsson\QueryBuilder\Traits\Column;
use Maarsson\QueryBuilder\Traits\GroupBy;
use Maarsson\QueryBuilder\Traits\Limit;
use Maarsson\QueryBuilder\Traits\Offset;
use Maarsson\QueryBuilder\Traits\OrderBy;
use Maarsson\QueryBuilder\Traits\Where;

class Statement
{
    use Column, GroupBy, Limit, Offset, OrderBy, Where;

    public $statement;
    public $table;

    public function table($table)
    {
        $this->table = new Table($table);

        return $this;
    }

    public function select(...$columns)
    {
        $this->statement = new Select();
        $this->addColumns($columns);

        return $this;
    }

    public function get()
    {
        return $this->run();
    }

    protected function run()
    {
        if (!$this->statement) {
            throw new \Exception('Statement is missing', 1000);
        }

        return $this->statement->query($this)->fetchAll();
    }
}
