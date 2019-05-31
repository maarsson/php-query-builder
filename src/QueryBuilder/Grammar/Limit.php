<?php

namespace Maarsson\QueryBuilder\Grammar;

use Maarsson\QueryBuilder\Dependencies\Syntax;

trait Limit
{
    protected function addLimit()
    {
        if (!$this->limit) {
            return null;
        }

        return Syntax::LIMIT . $this->limit;
    }
}
