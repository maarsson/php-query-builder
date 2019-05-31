<?php

namespace Maarsson\QueryBuilder\Grammar;

use Maarsson\QueryBuilder\Dependencies\Syntax;

trait GroupBy
{
    protected function addGroupBy()
    {
        if (count($this->groupBy) == 0) {
            return null;
        }

        $groupBys = implode(Syntax::COMMA, $this->groupBy);

        return Syntax::GROUPBY . $groupBys;
    }
}
