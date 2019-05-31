<?php

namespace Maarsson\QueryBuilder\Traits;

trait GroupBy
{
    public function groupBy(...$columns)
    {
        $this->addGroupBys($columns);
        return $this;
    }

    protected function addGroupBys(array $columns)
    {
        if (is_array($columns[0])) {
            return $this->addGroupBys($columns[0]);
        }

        foreach ($columns as $column) {
            $this->addGroupBy($column);
        }

    }

    protected function addGroupBy($column)
    {
        $this->statement->groupBy[] = $column;
    }
}
