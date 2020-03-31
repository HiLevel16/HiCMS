<?php 

namespace App\Admin\Model\MenuItem;

use Engine\Core\Database\ActiveRecord;

class MenuItem 
{

    use ActiveRecord;

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
     * $access_level
     *
     * @var undefined
     */
    public $access_level;

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
    public function getAccessLevel()
    {
        return $this->access_level;
    }

    /**
     * @param mixed $access_level
     *
     * @return self
     */
    public function setAccessLevel($access_level)
    {
        $this->access_level = $access_level;

        return $this;
    }
}