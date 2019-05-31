<?php

namespace Maarsson\QueryBuilder\Traits;

trait Column
{
    protected function addColumns(array $columns) {
        foreach ($columns as $column) {
            if ($this->table->hasColumn($column)) {
                $this->addColumn($column);
            }
        }
    }

    protected function addColumn($column)
    {
        if ($this->hasColumn($column)) {
            return $this;
        }

        $this->removeColumn('*');

        $this->statement->column[] = $column;
    }

    protected function hasColumn($column)
    {
        return in_array($column, $this->statement->column);
    }

    protected function removeColumn($column)
    {
        unset($this->statement->column[array_search('*', $this->statement->column, true)]);
    }
}
