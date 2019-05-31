<?php

namespace Maarsson\QueryBuilder;

use PDO;

/**
 * Database connection class, as an extension of build in PDO class.
 */
class Connection extends PDO
{
    /**
     * Mysql connection parameters with defaults.
     */
    protected $host = 'localhost';
    protected $port = '3306';
    protected $user = 'root';
    protected $password = '';
    protected $charset = 'utf8';
    protected $database = null;
    protected $table_prefix = null;
    protected $table_suffix = null;
    protected $options = [
        PDO::ATTR_ERRMODE  => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES  => false,
    ];

    /**
     * PDO connection storage.
     */
    private static $connection;


    /**
     * The PDO constructor extended by prefix and suffix parameters.
     */
    public function __construct()
    {
        $this->host = env('DB_HOST', $this->host);
        $this->port = env('DB_PORT', $this->port);
        $this->user = env('DB_USER', $this->user);
        $this->password = env('DB_PASSWD', $this->password);
        $this->charset = env('DB_CHARSET', $this->charset);
        $this->database = env('DB_DATABASE', $this->database);
        $this->table_prefix = env('DB_PREFIX', $this->table_prefix);
        $this->table_suffix = env('DB_SUFFIX', $this->table_suffix);

        $dsn = 'mysql:host='.$this->host.';';
        $dsn .= 'port='.$this->port.';';
        $dsn .= 'dbname='.$this->database.';';
        $dsn .= 'charset='.$this->charset;

        parent::__construct($dsn, $this->user, $this->password, $this->options);
    }


    /**
     * Builds up the database connection, using .env settings, or defaults.
     *
     * @return PDO
     */
    public static function init()
    {
        if (!self::$connection) {
            self::$connection = new self();
        }

        return self::$connection;
    }


    /**
     * The equivalent PDO method, but statement extends by prefix and suffix
     * parameters.
     *
     * @param string $statement
     *
     * @return PDO
     */
    public function exec($statement)
    {
        $statement = $this->applyPrefixSuffix($statement);
        return parent::exec($statement);
    }


    /**
     * The equivalent PDO method, but statement extends by prefix and suffix
     * parameters.
     *
     * @param string $statement
     * @param array $driver_options
     *
     * @return PDO
     */
    public function prepare($statement, $driver_options = array())
    {
        $statement = $this->applyPrefixSuffix($statement);
        return parent::prepare($statement, $driver_options);
    }


    /**
     * The equivalent PDO method, but statement extends by prefix and suffix
     * parameters.
     *
     * @param string $statement
     *
     * @return PDO
     */
    public function query($statement)
    {
        $statement = $this->applyPrefixSuffix($statement);
        $args      = func_get_args();

        if (count($args) > 1) {
            return call_user_func_array(array($this, 'parent::query'), $args);
        } else {
            return parent::query($statement);
        }
    }


    /**
     * Apply the prefix and suffix to the statement but statement extends by
     * prefix and suffix parameters.
     *
     * @param string $statement
     *
     * @return string $statement
     */
    protected function applyPrefixSuffix($statement)
    {
        return sprintf($statement, $this->table_prefix, $this->table_suffix);
    }
}
