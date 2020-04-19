<?php 

namespace App\Admin\Model\MenuItem;

use Engine\Core\Database\ActiveRecord;

class MenuItem 
{

    use ActiveRecord;

    protected $table = 'admin_menu';
    /**
     * $id
     *
     * @var undefined
     */
    public $id;

    /**
     * $link
     *
     * @var undefined
     */
    public $link;

    /**
     * $name
     *
     * @var undefined
     */
    public $name;

    /**
     * $icon
     *
     * @var undefined
     */
    public $icon;

    /**
     * $system_name
     *
     * @var undefined
     */
    public $system_name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $Link
     *
     * @return self
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $Icon
     *
     * @return self
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSystem_name()
    {
        return $this->access_level;
    }

    
    /**
     * setSystem_name
     *
     * @param mixed $system_name
     * @return void
     */
    public function setSystem_name($system_name)
    {
        $this->system_name = $system_name;

        return $this;
    }
}