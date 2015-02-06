<?php namespace Owlgrin\Guard;

use Illuminate\Support\Facades\Facade;

/**
 * The Guard Facade
 */
class GuardFacade extends Facade
{
	/**
	 * Returns the binding in IoC container
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'guard';
	}
}