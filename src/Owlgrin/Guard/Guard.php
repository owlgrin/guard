<?php namespace Owlgrin\Guard;

use Owlgrin\Guard\Storage\Storage;
use Owlgrin\Guard\GuardFilter;

/**
 * The Guard core
 */
class Guard {

	public function __construct(Storage $storage, GuardFilter $filter)
	{
		$this->storage = $storage;
		$this->filter = $filter;
	}

	public function getRole($userId, $appId)
	{
		return $this->storage->getRole($userId, $appId);
	}

	public function storeRole($userId, $appId, $role)
	{
		$this->storage->storeRole($userId, $appId, $role);
	}

	public function updateRoleForRestoredUser($userId)
	{
		$this->storage->updateRoleForRestoredUser($userId);
	}

	public function updateRoleForExpiredUser($userId)
	{
		$this->storage->updateRoleForExpiredUser($userId);
	}

	public function filter($userId, $appId, $level)
	{
		$this->filter->filter($userId, $appId, $level);
	}

	public function deleteRole($userId, $appId)
	{
		$this->storage->deleteRole($userId, $appId);
	}

}