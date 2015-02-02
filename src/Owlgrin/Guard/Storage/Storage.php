<?php namespace Owlgrin\Guard\Storage;

interface Storage {

	public function getRole($userId, $appId);
	public function storeRole($userId, $appId, $action);
	public function updateRoleForRestoredUser($userId);
	public function updateRoleForExpiredUser($userId);
}
