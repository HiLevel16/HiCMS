<?php 

namespace Engine\Core\Database;

/**
 * 
 */
trait ActiveRecord
{
	protected $db;

    protected $queryBuilder;
	
	function __construct($id = 0)
	{
		$dbCredentials = \Engine\Helper\Config\Config::getCoreConfig('DBsettings');
		$this->db = new \Engine\Core\Database\DB($dbCredentials);
        $this->queryBuilder = new QueryBuilder();

		if ($id) {
            $this->setId($id);
        }
	}

	public function getId()
	{
		return $this->id;
	}

	public function getTable()
    {
        return $this->table;
    }

    public function findOne()
    {
    	//SELECT * FROM :table WHERE id=:id
        $find = $this->db->query("SELECT * FROM :table WHERE id=:id", [
        'table' => $this->getTable(),
        'id' => $this->getId()
        ]);

        return isset($find[0]) ? $find[0] : null;
    }

    public function save() {
        $properties = $this->getIssetProperties();
        try {
            if (isset($this->id)) {
                $save = $this->db->query(
                    $this->queryBuilder->update($this->getTable())
                        ->set($properties)
                        ->where('id', $this->id)
                        ->sql(),
                    $this->queryBuilder->values
                );
            } else {

                $save = $this->db->query(
                    $this->queryBuilder->insert($this->getTable())
                        ->set($properties)
                        ->sql(),
                    $this->queryBuilder->values
                );
            }

            return $save;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    private function getIssetProperties()
    {
        $properties = [];

        foreach ($this->getProperties() as $key => $property) {
            if ($property->getName() == 'id') {
                continue;
            }

            if (isset($this->{$property->getName()})) {
                $properties[$property->getName()] = $this->{$property->getName()};
            }
        }

        return $properties;
    }

    /**
     * @return ReflectionProperty[]
     */
    private function getProperties()
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);

        return $properties;
    }
}