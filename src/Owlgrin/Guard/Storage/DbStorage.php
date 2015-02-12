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

	public function getPermission($userId, $objectId)
	{
		try
		{
			$permission = $this->db->table(Config::get('guard::tables.permission_user_app'))
				->where('user_id', $userId)
				->where('object_id', $objectId)
				->where('status', '1')
				->select('permission')
				->first();

			return $permission;
		}
		catch(PDOException $e)
		{
			throw new GuardExceptions\InternalException;
		}
	}

	public function storePermission($userId, $objectId, $permission = '8')
	{
		try
		{
			if( $permission != '8' and $permission != '4')
				throw new GuardExceptions\InvalidInputException('Invalid permission ' . $permission . ' is passed. Only 8 or 4 is valid.');

			$this->db->table(Config::get('guard::tables.permission_user_app'))->insertGetId(array(
					'user_id'       => $userId,
					'object_id'        => $objectId,
					'expiring_permission' => null,
					'permission'          => $permission,
					'action'        => $this->actions[$permission],
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

	public function updatePermissionForRestoredUser($userId)
	{
		try
		{
			$this->db->table(Config::get('guard::tables.permission_user_app'))
				->where('user_id', $userId)
				->where('status', '1')
				->update(array(
					'permission'          => $this->db->raw('expiring_permission'),
					'expiring_permission' => null,
					'expired_at'    => null
				));
		}
		catch(PDOException $e)
		{
			throw new GuardExceptions\InternalException;
		}
	}

	public function updatePermissionForExpiredUser($userId)
	{
		try
		{
			$this->db->table(Config::get('guard::tables.permission_user_app'))
				->where('user_id', $userId)
				->where('status', '1')
				->update(array(
					'expiring_permission' => $this->db->raw('permission'),
					'permission'          => 2,
					'expired_at'    => $this->db->raw('now()')
				));
		}
		catch(PDOException $e)
		{
			throw new GuardExceptions\InternalException;
		}
	}

	public function deletePermission($userId, $objectId)
	{
		try
		{
			$this->db->table(Config::get('guard::tables.permission_user_app'))
				->where('user_id', $userId)
				->where('object_id', $objectId)
				->where('status', '1')
				->update(array(
					'expired_at'    => $this->db->raw('now()'),
					'status'    	=> 0
				));
		}
		catch(PDOException $e)
		{
			throw new GuardExceptions\InternalException;
		}
	}
}