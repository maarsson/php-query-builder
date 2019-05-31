<?php

namespace Maarsson\QueryBuilder\Traits;

trait OrderBy
{
    public function orderBy(...$orderings)
    {
        $this->addOrderBys($orderings);
        return $this;
    }

    protected function addOrderBys(array $orderings)
    {
        if (is_array($orderings[0])) {
            return $this->addMultipleOrderBy($orderings[0]);
        }

        switch (count($orderings)) {
            case 1:
                $this->addOrderByAsAscending($orderings);
                break;

             case 2:
                $this->addOrderByAsDefined($orderings);
                break;

            default:
                throw new \Exception('Wrong format', 1200);
                break;
        }
    }

    protected function addOrderBy($column, $direction)
    {
        $this->statement->orderBy[] = [$column, $direction];
    }

    protected function addMultipleOrderBy($orderings)
    {
        foreach ($orderings as $ordering) {
            $this->addOrderBys($ordering);
        }
    }

    protected function addOrderByAsAscending($orderings)
    {
        $this->addOrderBy(
            $orderings[0],
            'ASC'
        );
    }

    protected function addOrderByAsDefined($orderings)
    {
        $this->addOrderBy(
            $orderings[0],
            $orderings[1]
        );
    }
}
