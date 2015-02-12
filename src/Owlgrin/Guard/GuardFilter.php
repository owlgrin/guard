<?php namespace Owlgrin\Guard;

use Owlgrin\Guard\Storage\Storage;
use Owlgrin\Guard\Exceptions as GuardExceptions;

class GuardFilter {

	protected $guard;
	protected $permissions;
	protected $levels;

	public function __construct(Storage $guard)
	{
		$this->guard = $guard;

		$this->permissions = array(
			'guest'       => 1,
			'subscriber'  => 2,
			'contributor' => 4,
			'creator'     => 8
		);

		$this->levels = array(
			'public'      => $this->permissions['guest'] | $this->permissions['subscriber'] | $this->permissions['contributor'] | $this->permissions['creator'],
			'subscriber'  => $this->permissions['subscriber'] | $this->permissions['contributor'] | $this->permissions['creator'],
			'contributor' => $this->permissions['contributor'] | $this->permissions['creator'],
			'creator'     => $this->permissions['creator']
		);
	}

	public function filter($userId, $objectId, $level)
	{
		// proceed only if input is present
		if( ! $userId or ! $objectId or ! $this->isAuthorized($userId, $objectId, $level))
			throw new GuardExceptions\ForbiddenException;
	}

	public function isAuthorized($userId, $objectId, $level)
	{
		if($level == 'public') return true; // if public, return true

		$permission = $this->guard->getPermission($userId, $objectId);

		if(! $permission) return false; // if no permission, return false

		if(($this->levels[$level] & $permission['permission']) !== 0) return true; // if authorized, return true

		return false;
	}
}