<?php

namespace Maarsson\QueryBuilder\Traits;

trait Where
{
    public function all()
    {
        $this->statement->where = [];

        return $this;
    }

    public function where(...$conditions)
    {
        $this->addWheres($conditions);

        return $this;
    }

    protected function addWheres(array $conditions)
    {
        switch (count($conditions)) {
            case 1:
                $this->addMultipleWhere($conditions[0]);
                break;

             case 2:
                $this->addWhereAsEquals($conditions);
                break;

            case 3:
                $this->addWhereAsDefined($conditions);
                break;

            default:
                throw new \Exception('Wrong format', 1100);
                break;
        }
    }

    protected function addWhere($column, $operator, $value)
    {
        $this->statement->where[] = [$column, $operator, $value];
    }

    protected function addMultipleWhere($conditions)
    {
        foreach ($conditions as $condition) {
            $this->addWheres($condition);
        }
    }

    protected function addWhereAsDefined($condition)
    {
        $this->addWhere(
            $condition[0],
            $condition[1],
            $condition[2]
        );
    }

    protected function addWhereAsEquals($condition)
    {
        $this->addWhere(
            $condition[0],
            '=',
            $condition[1]
        );
    }
}
