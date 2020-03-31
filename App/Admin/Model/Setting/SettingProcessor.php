<?php

namespace App\Admin\Model\Setting;

use Engine\Model;

/**
 * 
 */
class SettingProcessor extends Model
{
	
    public function change($id, $value)
    {
        $setting = new Setting();
        $setting->setId($id);
        $setting->setValue($value);
        $setting->save();
    }

    public function getSettings()
    {
        $query = $this->db->query('SELECT * FROM setting');
        return $query;
    }

    public function setSettings($settings)
    {
        $this->db->startTransaction();
        foreach ($settings as $key => $setting) {
            $this->db->addQueryToTransaction("UPDATE setting SET value = :value WHERE id=:id", [
                'value' => $setting,
                'id' => $key
            ]);
        }
        var_dump($this->db->commit());
    }
}