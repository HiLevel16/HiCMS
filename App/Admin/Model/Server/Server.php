<?php 

namespace App\Admin\Model\Server;

class Server 
{
    public $cpuUsage;

    public $ramUsage;

    public function __construct($parameters = [])
    {
        $this->cpuUsage = $parameters['cpuUsage'];
        
        $this->ramUsage = $parameters['ramUsage'];
    }

    public function getCpuUsage ()
    {
        return $this->cpuUsage;
    }

    public function setCpuUsage ($cpuUsage)
    {
        $this->cpuUsage = $cpuUsage;
    }

    public function getRamUsage ()
    {
        return $this->ramUsage;
    }

    public function setRamUsage ($ramUsage)
    {
        $this->ramUsage = $ramUsage;
    }
}