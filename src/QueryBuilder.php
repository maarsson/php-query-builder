<?php

namespace Maarsson;

use Maarsson\QueryBuilder\Statement;

class QueryBuilder
{
    public static function table($table)
    {
        return (new Statement())->table($table);
    }
}
