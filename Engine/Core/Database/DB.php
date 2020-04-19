<?php

namespace Engine\Core\Database;
/**
 * 
 */
class DB
{
	private $query;

	private $pdo;

	private $isConnected;

	private $credentials;

	private $parameters;

	private $statement;


	function __construct($credentials)
	{
		$this->credentials = $credentials;

        $this->connect();
	}

	private function connect()
	{
		$dsn = 'mysql:dbname=' . $this->credentials['dbname'] . ';host=' . $this->credentials['host'];

		try {
            $this->pdo = new \PDO($dsn, $this->credentials['user'], $this->credentials['password'], [
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' .$this->credentials['charset']
            ]);

            # Disable emulations and we can now log
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

            $this->isConnected = true;

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
	}

	public function close()
    {
        $this->pdo = null;

        $this->isConnected = false;
    }

    public function query($query, $parameters = [], $mode = \PDO::FETCH_OBJ)
    {
        $query = trim(str_replace('\r', '', $query));

        $this->init($query, $parameters);

        $rawStatement = explode(' ', preg_replace("/\s+|\t+|\n+/", " ", $query));

        $statement = strtolower($rawStatement[0]);

        if ($statement === 'select' || $statement === 'show') {
            return $this->statement->fetchAll($mode);
        } elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
            return $this->statement->rowCount();
        } else {
            return null;
        }
    }

    public function getPossibleValues($table, $column)
    {
        $cols = $this->query("SHOW COLUMNS FROM `{$table}` WHERE Field = :column", [
            'column' => $column
        ], \PDO::FETCH_ASSOC);

        $type = $cols[0]['Type'];
        preg_match('/enum\((.*)\)$/', $type, $matches);
        return explode(',', $matches[1]);
    }

    private function init($query, $parameters = [])
    {
        if (!$this->isConnected) {
            $this->connect();
        }

        try {
            # Prepare query
            $this->statement = $this->pdo->prepare($query);

            # Bind parameters
            $this->bind($parameters);
            if (!empty($this->parameters)) {
                foreach ($this->parameters as $param => $value) {
                    if (is_int($value[1])) {
                        $type = \PDO::PARAM_INT;
                    } elseif (is_bool($value[1])) {
                        $type = \PDO::PARAM_BOOL;
                    } elseif (is_null($value[1])) {
                        $type = \PDO::PARAM_NULL;
                    } else {
                        $type = \PDO::PARAM_STR;
                    }

                    $this->statement->bindValue($value[0], $value[1], $type);
                }
            }
            $this->statement->execute();

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }

        $this->parameters = [];
    }

    private function bind($parameters)
    {

        if (!empty($parameters) && is_array($parameters)) {
            $columns = array_keys($parameters);
            foreach ($columns as $i => $column) {
                $this->parameters[] = [
                    ':' . $column,
                    $parameters[$column]
                ];
            }
        }
    }

    public function startTransaction()
    {
    	$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  		$this->pdo->beginTransaction();
    }

    public function addQueryToTransaction($query, $parameters = [], $mode = \PDO::FETCH_ASSOC)
    {
    	$query = trim(str_replace('\r', '', $query));

        $query = $this->filter($query, $parameters);
        return $this->pdo->exec($query);
    }


    public function commit()
    {
    	try {
    		return $this->pdo->commit();
    	} catch (\Exception $e) {
    		$this->pdo->rollBack();
    		echo "Error: " . $e->getMessage();
    	}
    	
    }


    private function filter($query, $parameters)
    {

    	$this->bind($parameters);

        if (!empty($this->parameters)) {
            foreach ($this->parameters as $param => $value) {
                $value[1] = $this->escapeIdent($value[1]);
                $query = str_replace($value[0], $value[1], $query);
            }
        }

        $this->parameters = [];

        return $query;
    }

    private function escapeIdent($value)
	{
		return "'".str_replace("'","''",$value)."'";
	}

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
