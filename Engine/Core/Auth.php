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
	 * @param mixed $id
	 * @param mixed $hash
	 * @param mixed $oneTime
	 * @return void
	 */
	public function authorize($id, $hash, $remember = false)
	{
		$user = $this->db->query("UPDATE ".USER_TABLE." SET ".HASH_FIELD." = :hash WHERE id = :id", [
		"hash" => $hash,
		"id" => $id
		]);
		if ($user > 0) {
			$this->Id = $id;
			$this->authorized = true;
			Session::set(ID_SESSION_NAME, $hash, $remember);
		} elseif(DEBUG) {
			throw new \Exception("User with ID ".$id." doesn't exist", 1);
		}
	}

	/**
	 * unAuthorize
	 *
	 * @return void
	 */
	public function unAuthorize()
	{
		if ($this->getAuthorize()) {
			Session::delete(ID_SESSION_NAME);
			$this->db->query("UPDATE ".USER_TABLE." SET ".HASH_FIELD." = :hash WHERE id = :id", [
			"hash" => '',
			"id" => $this->getId()
			]);
			$this->authorized = false;
		}
		
	}

	/**
	 * getAuthorize
	 *
	 * @return void
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
		$user = $this->db->query("SELECT id FROM ".USER_TABLE." WHERE ".HASH_FIELD." = :hash LIMIT 1", [
		"hash" => $hash
		]);
		if (!empty($user[0]->id)) {
			$this->Id = $user[0]->id;
			$this->authorized = true;
		}
	}

}