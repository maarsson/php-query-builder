<?php

namespace Maarsson\QueryBuilder\Traits;

trait Offset
{
    public function offset($offset)
    {
        $this->addOffset($offset);
        return $this;
    }

    protected function addOffset($offset)
    {
        if (!$this->statement->limit) {
                throw new \Exception('Can not set offset without limit', 1400);
        }

        $this->statement->offset = $offset;
    }

}
