<?php namespace Owlgrin\Guard\Storage;

use PDOException, Config;
use Illuminate\Database\DatabaseManager as Database;

use Owlgrin\Guard\Exceptions as GuardExceptions;
use Owlgrin\Guard\Storage\Storage;

class DbStorage implements Storage {

	protected $db;
	protected $actions= ['8' => 'created', '4' => 'collaborated'];

	public function __construct(Database $db)
	{
		$this->db = $db->connection('mysql');
	}

	public function getRole($userId, $appId)
	{
		try
		{
			$role = $this->db->table(Config::get('guard::tables.permission_user_app'))
				->where('user_id', $userId)
				->where('app_id', $appId)
				->where('status', '1')
				->select('role')
				->first();

			return $role;
		}
		catch(PDOException $e)
		{
			throw new GuardExceptions\InternalException;
		}
	}

	public function storeRole($userId, $appId, $role = '8')
	{
		try
		{
			if( $role != '8' and $role != '4')
				throw new GuardExceptions\InvalidInputException('Invalid role ' . $role . ' is passed. Only 8 or 4 is valid.');

			$this->db->table(Config::get('guard::tables.permission_user_app'))->insertGetId(array(
					'user_id'       => $userId,
					'app_id'        => $appId,
					'expiring_role' => null,
					'role'          => $role,
					'action'        => $this->actions[$role],
					'status'        => '1',
					'expired_at'    => null
				)
			);
		}
		catch(PDOException $e)
		{
			throw new GuardExceptions\InternalException;
		}
	}

	public function updateRoleForRestoredUser($userId)
	{
		try
		{
			$this->db->table(Config::get('guard::tables.permission_user_app'))
				->where('user_id', $userId)
				->where('status', '1')
				->update(array(
					'role'          => $this->db->raw('expiring_role'),
					'expiring_role' => null,
					'expired_at'    => null
				));
		}
		catch(PDOException $e)
		{
			throw new GuardExceptions\InternalException;
		}
	}

	public function updateRoleForExpiredUser($userId)
	{
		try
		{
			$this->db->table(Config::get('guard::tables.permission_user_app'))
				->where('user_id', $userId)
				->where('status', '1')
				->update(array(
					'expiring_role' => $this->db->raw('role'),
					'role'          => 2,
					'expired_at'    => $this->db->raw('now()')
				));
		}
		catch(PDOException $e)
		{
			throw new GuardExceptions\InternalException;
		}
	}
}