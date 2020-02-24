<?php 
namespace Engine\Core;
/**
 * 
 */
use Engine\Helper\Session\Session;
use Engine\Core\Database\DB;

class Auth
{
	const ID_SESSION_NAME = "UID";

	const HASH_FIELD = "hash";

	const USER_TABLE = "user";

	private $authorized = false;

	private $Id = null;

	private $db;

	public function __construct()
	{
		$dbCredentials = \Engine\Helper\Config\Config::getCoreConfig('DBsettings');
		$this->db = new \Engine\Core\Database\DB($dbCredentials);

		$this->initUser(Session::get(self::ID_SESSION_NAME));
	}	
	
	public function authorize($hash, $id, $oneTime = false)
	{
		$user = $this->db->query("UPDATE ".self::USER_TABLE." SET ".self::HASH_FIELD." = :hash WHERE id = :id", [
		"hash" => $hash,
		"id" => $id
		]);
		if ($user > 0) {
			$this->Id = $id;
			$this->authorized = true;
			Session::set(self::ID_SESSION_NAME, $hash, $oneTime);
			$this->authorized = true;
		} elseif(DEBUG) {
			throw new \Exception("User with ID = ".$id." doesn't exist", 1);
		}
	}

	public function unAuthorize()
	{
		if ($this->getAuthorize()) {
			Session::delete(self::ID_SESSION_NAME);
			$this->db->query("UPDATE ".self::USER_TABLE." SET ".self::HASH_FIELD." = :hash WHERE id = :id", [
			"hash" => '',
			"id" => $this->getId()
			]);
			$this->authorized = false;
		}
		
	}

	public function getAuthorize()
	{
		return $this->authorized;
	}

	public function getId()
	{
		return $this->Id;
	}

	private function initUser($hash)
	{
		$user = $this->db->query("SELECT id FROM ".self::USER_TABLE." WHERE ".self::HASH_FIELD." = :hash", [
		"hash" => $hash
		]);
		if (!empty($user[0]['id'])) {
			$this->Id = $user[0]['id'];
			$this->authorized = true;
		}
	}

}