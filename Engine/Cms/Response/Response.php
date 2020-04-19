<?php


namespace Engine\Cms\Response;


class Response
{
    public $status;

    public $message;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getString()
    {
        $output = [];
        $this->status ? $output['status'] = 'success' : $output['status'] = 'error';
        $output['message'] = $this->getMessage();
        return json_encode($output);
    }

    public function initAsError($message)
    {
        $this->setStatus(false);
        $this->setMessage($message);
    }

    public function initAsSuccess($message)
    {
        $this->setStatus(true);
        $this->setMessage($message);
    }


}