<?php

namespace Maarsson\QueryBuilder\Grammar;

use Maarsson\QueryBuilder\Dependencies\Syntax;

trait Where
{
    protected function addWheres()
    {
        if (count($this->where) == 0) {
            return null;
        }

        $wheres = array_map(
            function ($where) {
                    return $where[0] . Syntax::SPACE . $where[1] . Syntax::QUESTIONMARK;
            },
            $this->where
        );

        return Syntax::WHERE . implode(Syntax::OPERATOR_AND, $wheres);
    }
}
