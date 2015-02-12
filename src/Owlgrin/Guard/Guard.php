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

	public function getPermission($userId, $objectId)
	{
		return $this->storage->getPermission($userId, $objectId);
	}

	public function storePermission($userId, $objectId, $permission = '8')
	{
		$this->storage->storePermission($userId, $objectId, $permission);
	}

	public function updatePermissionForRestoredUser($userId)
	{
		$this->storage->updatePermissionForRestoredUser($userId);
	}

	public function updatePermissionForExpiredUser($userId)
	{
		$this->storage->updatePermissionForExpiredUser($userId);
	}

	public function filter($userId, $objectId, $level)
	{
		$this->filter->filter($userId, $objectId, $level);
	}

	public function deletePermission($userId, $objectId)
	{
		$this->storage->deletePermission($userId, $objectId);
	}

}