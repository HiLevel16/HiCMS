<?php 
namespace Engine\Core;
/**
 * 
 */
use Engine\Helper\Session\Session;
use Engine\Core\Database\DB;

class Auth
{

	/**
	 * $authorized
	 *
	 * @var boolean
	 */
	private $authorized = false;

	/**
	 * $Id
	 *
	 * @var null
	 */
	private $Id = null;

	/**
	 * $db
	 *
	 * @var undefined
	 */
	private $db;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		$dbCredentials = \Engine\Helper\Config\Config::getCoreConfig('DBsettings');
		$this->db = new \Engine\Core\Database\DB($dbCredentials);

		$this->initUser(Session::get(ID_SESSION_NAME));
	}

    /**
     * authorize
     *
     * @param $parameters
     * @param bool $remember
     * @return void
     * @throws \Exception
     */
	public function authorize($parameters, $remember = false)
	{

		$user = $this->db->query("INSERT INTO ".SESSION_TABLE." (userId, hash, ip, userAgent) VALUES (:userId, :hash, :ip, :userAgent)", [
            "userId" => $parameters['id'],
		    "hash" => $parameters['hash'],
            "ip" => $parameters['ip'],
            "userAgent" => $parameters['userAgent']
		]);
		if ($user > 0) {
			$this->Id = $parameters['id'];
			$this->authorized = true;
			Session::set(ID_SESSION_NAME, $parameters['hash'], $remember);
		} elseif(DEBUG) {
			throw new \Exception("User with ID ".$parameters['id']." doesn't exist", 1);
		}
	}

    /**
     * unAuthorize
     *
     * @param $hash
     * @return void
     */
	public function unAuthorize($hash)
	{
		if ($this->getAuthorize()) {
			$this->db->query("DELETE FROM ".SESSION_TABLE." WHERE ".HASH_FIELD." = :hash AND userId = :id", [
			"hash" => $hash,
			"id" => $this->getId()
			]);
            Session::delete(ID_SESSION_NAME);
			$this->authorized = false;
		}
		
	}

    /**
     * getAuthorize
     *
     * @return bool
     */
	public function getAuthorize()
	{
		return $this->authorized;
	}

	/**
	 * getId
	 *
	 * @return void
	 */
	public function getId()
	{
		return $this->Id;
	}

	/**
	 * initUser
	 *
	 * @param mixed $hash
	 * @return void
	 */
	private function initUser($hash)
	{
		$user = $this->db->query("SELECT userId FROM ".SESSION_TABLE." WHERE ".HASH_FIELD." = :hash LIMIT 1", [
		    "hash" => $hash
		]);
		if (!empty($user[0]->userId)) {
			$this->Id = $user[0]->userId;
			$this->authorized = true;
		}
	}

}