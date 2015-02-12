<?php namespace Owlgrin\Guard\Storage;

interface Storage {

	public function getPermission($userId, $objectId);
	public function storePermission($userId, $objectId, $action);
	public function updatePermissionForRestoredUser($userId);
	public function updatePermissionForExpiredUser($userId);
}
