<?php namespace Owlgrin\Guard;

use Owlgrin\Guard\Storage\Storage as Guard;

class GuardFilter {

	protected $guard;
	protected $roles;
	protected $levels;

	public function __construct(Guard $guard)
	{
		$this->guard = $guard;

		$this->roles = array(
			'guest'       => 1,
			'subscriber'  => 2,
			'contributor' => 4,
			'creator'     => 8
		);

		$this->levels = array(
			'public'      => $this->roles['guest'] | $this->roles['subscriber'] | $this->roles['contributor'] | $this->roles['creator'],
			'subscriber'  => $this->roles['subscriber'] | $this->roles['contributor'] | $this->roles['creator'],
			'contributor' => $this->roles['contributor'] | $this->roles['creator'],
			'creator'     => $this->roles['creator']
		);
	}

	public function isAuthorized($userId, $appId, $level)
	{
		if($level == 'public') return true; // if public, return true

		$role = $this->guard->getRole($userId, $appId);

		if(! $role) return false; // if no role, return false

		if(($this->levels[$level] & $role['role']) !== 0) return true; // if authorized, return true

		return false;
	}
}