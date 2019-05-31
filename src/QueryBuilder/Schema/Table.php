<?php

namespace Maarsson\QueryBuilder\Schema;

use Maarsson\QueryBuilder\Connection;
use Maarsson\QueryBuilder\Dependencies\Syntax;

class Table
{
    public $name;

    protected $columns = [];
    protected static $tableInfo = null;

    public function __construct($table)
    {
        $this->name = $table;
        $this->loadColumns();

        return $this;
    }

    public function hasColumn($column)
    {
        return in_array($column, $this->columns);
    }

    /**
     * Get data table column info.
     *
     * @return (array)
     */
    protected static function loadTableInfo($table)
    {
        if (empty(static::$tableInfo)) {
            $stmt = Connection::init()->prepare(
                Syntax::DESCRIBE.$table.';'
            );
            $stmt->execute();
            static::$tableInfo = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }


    /**
     * Get model property fields by data table.
     *
     * @return (array) of available columns
     */
    public function loadColumns()
    {
        static::loadTableInfo($this->name);

        foreach (static::$tableInfo as $column) {
            if (is_array($column)) {
                $this->columns[] = $column['Field'];
            }
        }
    }


}
