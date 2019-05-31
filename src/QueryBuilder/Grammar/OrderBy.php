<?php

namespace Maarsson\QueryBuilder\Grammar;

use Maarsson\QueryBuilder\Dependencies\Syntax;

trait OrderBy
{
    protected function addOrderBy()
    {
        if (count($this->orderBy) == 0) {
            return null;
        }

        $orderBys = array_map(
            function ($orderBy) {
                    return implode(Syntax::SPACE, $orderBy);
            },
            $this->orderBy
        );

        return Syntax::ORDERBY . implode(Syntax::COMMA, $orderBys);
    }
}
