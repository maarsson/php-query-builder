<?php

namespace Maarsson\QueryBuilder\Grammar;

use Maarsson\QueryBuilder\Dependencies\Syntax;

trait Select
{
    public $grammar = [];

    protected function addStatement()
    {
        $columns = implode(Syntax::COMMA, $this->column);
        $table = $this->statement->table->name;

        return Syntax::SELECT . $columns . Syntax::FROM . $table;
    }
}
