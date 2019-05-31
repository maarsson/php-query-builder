<?php

namespace Maarsson\QueryBuilder\Traits;

trait Limit
{
    public function limit(...$limit)
    {
        $this->addLimits($limit);

        return $this;
    }

    protected function addLimits(array $limit)
    {
        switch (count($limit)) {
            case 1:
                $this->addLimit($limit[0]);
                break;

             case 2:
                $this->addLimit($limit[0]);
                $this->addOffset($limit[1]);
                break;

            default:
                throw new \Exception('Wrong format', 1300);
                break;
        }
    }

    protected function addLimit($limit)
    {
        $this->statement->limit = $limit;
    }
}
