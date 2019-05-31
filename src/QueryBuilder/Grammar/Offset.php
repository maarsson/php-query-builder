<?php

namespace Maarsson\QueryBuilder\Grammar;

use Maarsson\QueryBuilder\Dependencies\Syntax;

trait Offset
{
    protected function addOffset()
    {
        if (!$this->offset) {
            return null;
        }

        return Syntax::OFFSET . $this->offset;
    }
}
